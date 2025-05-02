$(document).ready(function() {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Smooth scrolling for navigation links
    $('.begin-btn, a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        const targetId = $(this).attr('href');
        const targetElement = $(targetId);
        
        if (targetElement.length) {
            $('html, body').animate({
                scrollTop: targetElement.offset().top
            }, {
                duration: 1000,
                easing: 'swing'
            });
        }
    });

    // Load personal info
    loadPersonalInfo();
    
    // Load experiences
    loadExperiences();
    
    // Load skills
    loadSkills();
    
    // Load projects
    loadProjects();

    // Handle form submissions
    $('#saveExperience').on('click', saveExperience);
    $('#saveSkill').on('click', saveSkill);
    $('#saveProject').on('click', saveProject);
});

// Load Personal Info
function loadPersonalInfo() {
    $.get('api/get_personal_info.php', function(data) {
        if (data.success) {
            const info = data.data;
            $('#personal-info').html(`
                <h3>${info.name}</h3>
                <p class="lead">${info.title}</p>
                <p>${info.bio}</p>
                <div class="mt-4">
                    <p><i class="fas fa-graduation-cap"></i> ${info.school}</p>
                    <p><i class="fas fa-map-marker-alt"></i> ${info.location}</p>
                    <p><i class="fas fa-envelope"></i> ${info.email}</p>
                    <p><i class="fas fa-phone"></i> ${info.phone}</p>
                </div>
            `);
            if (info.profile_image) {
                $('#profile-image').attr('src', info.profile_image);
            }
        }
    });
}

// Load Experiences
function loadExperiences() {
    $.get('api/get_experiences.php', function(data) {
        if (data.success) {
            const experiences = data.data;
            let html = '';
            experiences.forEach(exp => {
                html += `
                    <div class="experience-card fade-in">
                        <h4>${exp.title}</h4>
                        <h5>${exp.company}</h5>
                        <p class="text-muted">
                            <i class="fas fa-calendar"></i> ${formatDate(exp.start_date)} - ${exp.end_date ? formatDate(exp.end_date) : 'Present'}
                        </p>
                        <p>${exp.description}</p>
                    </div>
                `;
            });
            $('#experience-list').html(html);
        }
    });
}

// Load Skills
function loadSkills() {
    $.get('api/get_skills.php', function(data) {
        if (data.success) {
            const skills = data.data;
            let html = '';
            skills.forEach(skill => {
                html += `
                    <div class="col-md-4">
                        <div class="skill-card fade-in">
                            <h4>${skill.name}</h4>
                            <p class="text-muted">${skill.category}</p>
                            <div class="skill-progress">
                                <div class="skill-progress-bar" style="width: ${skill.proficiency}%"></div>
                            </div>
                        </div>
                    </div>
                `;
            });
            $('#skills-list').html(html);
        }
    });
}

// Load Projects
function loadProjects() {
    $.get('api/get_projects.php', function(data) {
        if (data.success) {
            const projects = data.data;
            let html = '';
            projects.forEach(project => {
                html += `
                    <div class="col-md-6">
                        <div class="project-card fade-in">
                            ${project.image_url ? `<img src="${project.image_url}" class="project-image" alt="${project.title}">` : ''}
                            <div class="project-content">
                                <h4>${project.title}</h4>
                                <p>${project.description}</p>
                                <p class="text-muted"><i class="fas fa-code"></i> ${project.technologies}</p>
                                ${project.project_url ? `<a href="${project.project_url}" class="btn btn-primary" target="_blank">View Project</a>` : ''}
                            </div>
                        </div>
                    </div>
                `;
            });
            $('#projects-list').html(html);
        }
    });
}

// Save Experience
function saveExperience() {
    const formData = new FormData($('#addExperienceForm')[0]);
    $.ajax({
        url: 'api/save_experience.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#addExperienceModal').modal('hide');
                loadExperiences();
                $('#addExperienceForm')[0].reset();
            }
        }
    });
}

// Save Skill
function saveSkill() {
    const formData = new FormData($('#addSkillForm')[0]);
    $.ajax({
        url: 'api/save_skill.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#addSkillModal').modal('hide');
                loadSkills();
                $('#addSkillForm')[0].reset();
            }
        }
    });
}

// Save Project
function saveProject() {
    const formData = new FormData($('#addProjectForm')[0]);
    $.ajax({
        url: 'api/save_project.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#addProjectModal').modal('hide');
                loadProjects();
                $('#addProjectForm')[0].reset();
            }
        }
    });
}

// Utility function to format dates
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long' };
    return new Date(dateString).toLocaleDateString(undefined, options);
} 