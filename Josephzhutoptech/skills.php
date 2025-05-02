<?php
require_once 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills - Joseph Zhu - B.S. Computer Science/University of Central Florida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="section-padding">
        <div class="container">
            <h2 class="section-title">Skills</h2>
            
            <!-- Skills List -->
            <div class="row" id="skills-list">
                <?php
                $stmt = $pdo->query("SELECT * FROM skills ORDER BY category, name");
                $currentCategory = '';
                while ($skill = $stmt->fetch(PDO::FETCH_ASSOC)):
                    if ($currentCategory !== $skill['category']):
                        if ($currentCategory !== '') echo '</div>'; // Close previous category div
                        $currentCategory = $skill['category'];
                ?>
                    <div class="col-12">
                        <h3 class="skill-category mt-4 mb-3"><?php echo htmlspecialchars($currentCategory); ?></h3>
                        <div class="row">
                <?php endif; ?>
                    <div class="col-md-6 mb-4">
                        <div class="content-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <h4><?php echo htmlspecialchars($skill['name']); ?></h4>
                                <?php if (isset($_SESSION['is_admin'])): ?>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-danger delete-skill"
                                                data-id="<?php echo $skill['id']; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p class="skill-description"><?php echo htmlspecialchars($skill['description']); ?></p>
                        </div>
                    </div>
                <?php endwhile; 
                if ($currentCategory !== '') echo '</div>'; // Close last category div
                ?>
            </div>

            <?php if (isset($_SESSION['is_admin'])): ?>
                <!-- Add Skill Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addSkillModal">
                        <i class="fas fa-plus"></i> Add Skill
                    </button>
                </div>
            <?php endif; ?>

            <!-- Navigation Buttons -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="experience.php" class="btn btn-secondary btn-lg me-3">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <a href="projects.php" class="btn btn-primary btn-lg">
                        Next <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Skill Modal -->
    <div class="modal fade" id="addSkillModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addSkillForm">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" name="category" 
                                   list="existingCategories">
                            <datalist id="existingCategories">
                                <?php
                                $categories = $pdo->query("SELECT DISTINCT category FROM skills ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
                                foreach ($categories as $category) {
                                    echo "<option value=\"" . htmlspecialchars($category) . "\">";
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div id="formFeedback" class="alert d-none"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveSkill">Save Skill</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function showLoading(button) {
                const originalText = button.html();
                button.attr('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...')
                    .data('original-text', originalText);
            }

            function hideLoading(button) {
                button.attr('disabled', false)
                    .html(button.data('original-text'));
            }

            function showFeedback(type, message) {
                const feedback = $('#formFeedback');
                feedback.removeClass('d-none alert-success alert-danger')
                    .addClass(`alert-${type}`)
                    .html(message);
            }

            // Save new skill
            $('#saveSkill').click(function() {
                const button = $(this);
                const form = $('#addSkillForm')[0];
                
                showLoading(button);
                const formData = new FormData(form);

                $.ajax({
                    url: 'handlers/save_skill.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        try {
                            const result = typeof response === 'object' ? response : JSON.parse(response);
                            if (result.success) {
                                $('#addSkillModal').modal('hide');
                                location.reload();
                            } else {
                                alert(result.message || 'Error saving skill');
                                hideLoading(button);
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

            // Delete skill
            $('.delete-skill').click(function() {
                const button = $(this);
                const id = button.data('id');
                const card = button.closest('.content-card').parent();
                
                showLoading(button);

                $.ajax({
                    url: 'handlers/delete_skill.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        try {
                            const result = typeof response === 'object' ? response : JSON.parse(response);
                            if (result.success) {
                                card.fadeOut(400, function() {
                                    $(this).remove();
                                    // If this was the last skill in its category, remove the category heading
                                    const categoryRow = $(this).closest('.row');
                                    if (categoryRow.find('.content-card').length === 0) {
                                        categoryRow.prev('h3.skill-category').remove();
                                        categoryRow.remove();
                                    }
                                    // If no skills left at all, reload the page
                                    if ($('.content-card').length === 0) {
                                        location.reload();
                                    }
                                });
                            } else {
                                alert(result.message || 'Error deleting skill');
                                hideLoading(button);
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

            // Reset form and feedback when modal is closed
            $('#addSkillModal').on('hidden.bs.modal', function() {
                $('#addSkillForm')[0].reset();
                hideLoading($('#saveSkill'));
            });
        });
    </script>
</body>
</html> 