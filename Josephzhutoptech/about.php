<?php
require_once 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Joseph Zhu - B.S. Computer Science/University of Central Florida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="section-padding">
        <div class="container">
            <h2 class="section-title">About Me</h2>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-image-container">
                        <?php
                        $stmt = $pdo->query("SELECT * FROM about LIMIT 1");
                        $about = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <img src="<?php echo htmlspecialchars($about['image_url'] ?? 'assets/images/default-profile.jpg'); ?>" 
                             alt="Profile Image" 
                             id="profile-image" 
                             class="img-fluid rounded-circle">
                        <?php if (isset($_SESSION['is_admin'])): ?>
                            <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#editImageModal">
                                <i class="fas fa-camera"></i> Change Image
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="about-content">
                        <?php if (isset($_SESSION['is_admin'])): ?>
                            <button class="btn btn-sm btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#editAboutModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($about['name'] ?? 'Your Name'); ?></h3>
                        <p class="lead"><?php echo htmlspecialchars($about['title'] ?? 'Your Title'); ?></p>
                        <div class="about-text">
                            <?php echo nl2br(htmlspecialchars($about['description'] ?? 'Your description here...')); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="index.php" class="btn btn-secondary btn-lg me-3">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <a href="experience.php" class="btn btn-primary btn-lg">
                        Next <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit About Modal -->
    <div class="modal fade" id="editAboutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit About Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editAboutForm">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($about['name'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($about['title'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="6" required><?php echo htmlspecialchars($about['description'] ?? ''); ?></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveAbout">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Image Modal -->
    <div class="modal fade" id="editImageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Profile Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editImageForm" enctype="multipart/form-data" method="post">
                        <div class="mb-3">
                            <label class="form-label">Upload Image</label>
                            <input type="file" class="form-control" name="image" accept="image/jpeg,image/png,image/gif" required>
                            <small class="text-muted">Max file size: 5MB. Supported formats: JPG, PNG, GIF</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveImage">Save Image</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Save about info
            $('#saveAbout').click(function(e) {
                e.preventDefault();
                
                // Show loading state
                const $button = $(this);
                $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
                
                const formData = new FormData($('#editAboutForm')[0]);
                
                $.ajax({
                    url: 'handlers/save_about.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let jsonResponse;
                        
                        // First try to parse the response if it's a string
                        if (typeof response === 'string') {
                            try {
                                jsonResponse = JSON.parse(response);
                            } catch (e) {
                                // If parsing fails but response includes success, consider it successful
                                if (response.includes('success')) {
                                    $('#editAboutModal').modal('hide');
                                    setTimeout(() => location.reload(), 500);
                                    return;
                                }
                            }
                        } else {
                            jsonResponse = response;
                        }

                        // If we have a valid JSON response
                        if (jsonResponse && jsonResponse.success) {
                            $('#editAboutModal').modal('hide');
                            setTimeout(() => location.reload(), 500);
                        } else if (jsonResponse && jsonResponse.message) {
                            // Only show error message if it's a real error
                            console.warn('Save warning:', jsonResponse);
                            alert(jsonResponse.message);
                        } else {
                            // If no error message but save worked, just reload
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        // Only show error if it's a real error (not 200 OK)
                        if (xhr.status !== 200) {
                            console.error('Save error:', {
                                status: status,
                                error: error,
                                response: xhr.responseText
                            });
                            alert('Error saving information. Please try again.');
                        } else {
                            // If status is 200 but we got here, just reload
                            location.reload();
                        }
                    },
                    complete: function() {
                        $button.prop('disabled', false).html('Save Changes');
                    }
                });
            });

            // Save image
            $('#saveImage').click(function(e) {
                e.preventDefault();
                
                const fileInput = $('input[name="image"]')[0];
                if (!fileInput.files || !fileInput.files[0]) {
                    alert('Please select an image file');
                    return;
                }

                const file = fileInput.files[0];
                if (file.size > 5000000) {
                    alert('File is too large. Maximum size is 5MB.');
                    return;
                }

                const formData = new FormData($('#editImageForm')[0]);
                
                // Show loading state
                const $button = $(this);
                $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...');
                
                $.ajax({
                    url: 'handlers/save_about.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        try {
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }
                            
                            if (response.success) {
                                $('#editImageModal').modal('hide');
                                // Wait a brief moment before reloading to ensure the modal is hidden
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            } else if (response.message) {
                                console.warn('Upload warning:', response);
                                alert(response.message);
                            }
                        } catch (e) {
                            // If we get here but the image was actually uploaded,
                            // just reload the page without showing an error
                            if (response.includes('success')) {
                                location.reload();
                            } else {
                                console.error('Error parsing response:', e);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Only show error if it's a real error
                        if (xhr.status !== 200) {
                            console.error('Upload error:', {
                                status: status,
                                error: error,
                                response: xhr.responseText
                            });
                            alert('Error uploading image. Please try again.');
                        } else {
                            // If status is 200 but we got here, just reload
                            location.reload();
                        }
                    },
                    complete: function() {
                        $button.prop('disabled', false).html('Save Image');
                    }
                });
            });
        });
    </script>
</body>
</html> 