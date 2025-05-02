<?php
require_once 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience - Joseph Zhu - B.S. Computer Science/University of Central Florida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="section-padding">
        <div class="container">
            <h2 class="section-title">Experience</h2>
            
            <!-- Experience List -->
            <div class="row" id="experience-list">
                <?php
                $stmt = $pdo->query("SELECT * FROM experiences ORDER BY start_date DESC");
                while ($exp = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col-md-6 mb-4">
                        <div class="content-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <h3><?php echo htmlspecialchars($exp['title']); ?></h3>
                                <?php if (isset($_SESSION['is_admin'])): ?>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-danger delete-experience"
                                                data-id="<?php echo $exp['id']; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p class="company"><?php echo htmlspecialchars($exp['company']); ?></p>
                            <p class="date">
                                <?php 
                                    $start_date = date('m/d/Y', strtotime($exp['start_date']));
                                    $end_date = $exp['end_date'] ? date('m/d/Y', strtotime($exp['end_date'])) : 'Present';
                                    echo $start_date . ' - ' . $end_date;
                                ?>
                            </p>
                            <p><?php echo htmlspecialchars($exp['description']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php if (isset($_SESSION['is_admin'])): ?>
                <!-- Add Experience Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addExperienceModal">
                        <i class="fas fa-plus"></i> Add Experience
                    </button>
                </div>
            <?php endif; ?>

            <!-- Navigation Buttons -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="about.php" class="btn btn-secondary btn-lg me-3">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <a href="skills.php" class="btn btn-primary btn-lg">
                        Next <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Experience Modal -->
    <div class="modal fade" id="addExperienceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addExperienceForm">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Company</label>
                            <input type="text" class="form-control" name="company">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date">
                                <small class="form-text text-muted">Leave empty if this is your current position</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4"></textarea>
                        </div>
                        <div id="formFeedback" class="alert d-none"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveExperience">Save Experience</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Save new experience
            $('#saveExperience').click(function() {
                const form = $('#addExperienceForm')[0];
                const formData = new FormData(form);

                $.ajax({
                    url: 'handlers/save_experience.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        try {
                            const result = typeof response === 'object' ? response : JSON.parse(response);
                            if (result.success) {
                                $('#addExperienceModal').modal('hide');
                                location.reload();
                            } else {
                                alert(result.message || 'Error saving experience');
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error details:', xhr.responseText);
                        location.reload();
                    }
                });
            });

            // Delete experience
            $('.delete-experience').click(function() {
                const id = $(this).data('id');

                $.ajax({
                    url: 'handlers/delete_experience.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        try {
                            const result = typeof response === 'object' ? response : JSON.parse(response);
                            if (result.success) {
                                location.reload();
                            } else {
                                alert(result.message || 'Error deleting experience');
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error details:', xhr.responseText);
                        location.reload();
                    }
                });
            });

            // Reset form when modal is closed
            $('#addExperienceModal').on('hidden.bs.modal', function() {
                $('#addExperienceForm')[0].reset();
            });
        });
    </script>
</body>
</html> 