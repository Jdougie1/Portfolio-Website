<?php
require_once 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Why Choose Me - Joseph Zhu - B.S. Computer Science/University of Central Florida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="section-padding">
        <div class="container">
            <h2 class="section-title">Why Choose Me for Toptech Systems</h2>
            
            <!-- Reasons List -->
            <div class="row" id="reasons-list">
                <?php
                $stmt = $pdo->query("SELECT * FROM whychooseme ORDER BY created_at DESC");
                while ($reason = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col-md-6 mb-4">
                        <div class="content-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <h3><?php echo htmlspecialchars($reason['title']); ?></h3>
                                <?php if (isset($_SESSION['is_admin'])): ?>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-danger delete-reason"
                                                data-id="<?php echo $reason['id']; ?>"
                                                title="Delete Reason">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p><?php echo htmlspecialchars($reason['description']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php if (isset($_SESSION['is_admin'])): ?>
                <!-- Add Reason Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addReasonModal">
                        <i class="fas fa-plus"></i> Add Reason
                    </button>
                </div>
            <?php endif; ?>

            <!-- Navigation Buttons -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="projects.php" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Reason Modal -->
    <div class="modal fade" id="addReasonModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Reason</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addReasonForm">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveReason">Save Reason</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Save new reason
            $('#saveReason').click(function() {
                const formData = new FormData($('#addReasonForm')[0]);
                $.ajax({
                    url: 'handlers/save_reason.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        try {
                            const result = typeof response === 'object' ? response : JSON.parse(response);
                            if (result.success) {
                                $('#addReasonModal').modal('hide');
                                location.reload();
                            } else {
                                alert(result.message || 'Error saving reason');
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

            // Delete reason
            $('.delete-reason').click(function() {
                const id = $(this).data('id');

                $.ajax({
                    url: 'handlers/delete_reason.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        try {
                            const result = typeof response === 'object' ? response : JSON.parse(response);
                            if (result.success) {
                                location.reload();
                            } else {
                                alert(result.message || 'Error deleting reason');
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
            $('#addReasonModal').on('hidden.bs.modal', function() {
                $('#addReasonForm')[0].reset();
            });
        });
    </script>
</body>
</html> 