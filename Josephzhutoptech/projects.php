<?php
require_once 'config.php';
session_start();

// Temporary debug - remove after testing
echo "Session contents:<br>";
var_dump($_SESSION);
echo "<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Joseph Zhu - B.S. Computer Science/University of Central Florida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="section-padding">
        <div class="container">
            <h2 class="section-title">Projects</h2>
            
            <div class="row">
                <?php
                $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
                while ($project = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                <div class="col-md-6 mb-4">
                    <div class="content-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <h4><?php echo htmlspecialchars($project['title']); ?></h4>
                            <?php if (isset($_SESSION['is_admin'])): ?>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-danger delete-project"
                                            data-id="<?php echo $project['id']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="text-muted">
                            <?php 
                            $start_date = date('m/d/Y', strtotime($project['start_date']));
                            $end_date = $project['end_date'] ? date('m/d/Y', strtotime($project['end_date'])) : 'Present';
                            echo $start_date . ' - ' . $end_date;
                            ?>
                        </p>
                        <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                        <div class="mt-3">
                            <?php if (!empty($project['github_url'])): ?>
                                <a href="<?php echo htmlspecialchars($project['github_url']); ?>" class="btn btn-outline-primary me-2" target="_blank">
                                    <i class="fab fa-github"></i> GitHub
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($project['demo_url'])): ?>
                                <a href="<?php echo htmlspecialchars($project['demo_url']); ?>" class="btn btn-outline-secondary" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> Demo
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <?php if (isset($_SESSION['is_admin'])): ?>
            <!-- Add Project Modal Button -->
            <div class="text-center mt-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="fas fa-plus"></i> Add Project
                </button>
            </div>

            <!-- Add Project Modal -->
            <div class="modal fade" id="addProjectModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Project</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addProjectForm">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="4"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date">
                                    <small class="text-muted">Leave blank if ongoing</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">GitHub URL</label>
                                    <input type="url" class="form-control" name="github_url">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Demo URL</label>
                                    <input type="url" class="form-control" name="demo_url">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveProject">Save Project</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Navigation Buttons -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="skills.php" class="btn btn-secondary btn-lg me-3">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <a href="whychooseme.php" class="btn btn-primary btn-lg">
                        Next <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Save project
            $('#saveProject').click(function(e) {
                e.preventDefault();
                const form = $('#addProjectForm')[0];
                const formData = new FormData(form);
                
                $.ajax({
                    url: 'handlers/save_project.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        try {
                            const result = typeof response === 'object' ? response : JSON.parse(response);
                            if (result.success) {
                                $('#addProjectModal').modal('hide');
                                location.reload();
                            } else {
                                alert(result.message || 'Error saving project');
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

            // Delete project
            $('.delete-project').click(function() {
                const id = $(this).data('id');
                
                $.ajax({
                    url: 'handlers/delete_project.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        try {
                            const result = typeof response === 'object' ? response : JSON.parse(response);
                            if (result.success) {
                                location.reload();
                            } else {
                                alert(result.message || 'Error deleting project');
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
            $('#addProjectModal').on('hidden.bs.modal', function() {
                $('#addProjectForm')[0].reset();
            });
        });
    </script>
</body>
</html> 