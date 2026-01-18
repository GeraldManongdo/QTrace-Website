/**
 * QTrace Report & Chat System
 */

let currentReportID = null;
let currentProjectID = null;
let chatRefreshInterval = null;
let isUserAdmin = false;

function initReportSystem(projectID, userRole) {
    currentProjectID = projectID;
    isUserAdmin = (userRole === 'admin');
    
    loadProjectReports();
    
    document.getElementById('newReportBtn')?.addEventListener('click', openReportModal);
    document.getElementById('submitReportBtn')?.addEventListener('click', submitNewReport);
    document.getElementById('sendMessageBtn')?.addEventListener('click', sendMessage);
    document.getElementById('closeChatBtn')?.addEventListener('click', closeChat);
    
    document.getElementById('messageInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
}

function loadProjectReports() {
    fetch(`/QTrace-Website/database/controllers/get_project_reports.php?project_id=${currentProjectID}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayReportsList(data.reports);
                updateReportCount(data.count);
            } else {
                console.error('Failed to load reports:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading reports:', error);
        });
}

function displayReportsList(reports) {
    const container = document.getElementById('reportsList');
    
    if (reports.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <p class="mt-3">No reports yet for this project</p>
                <p class="small">Be the first to report an issue</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = reports.map(report => {
        const statusClass = {
            'open': 'warning',
            'in progress': 'info',
            'resolved': 'success'
        }[report.report_status] || 'secondary';
        
        const timeAgo = getTimeAgo(report.last_activity);
        
        return `
            <div class="report-item" onclick="openChat(${report.report_ID})">
                <div class="report-item-header">
                    <div>
                        <h6 class="fw-bold mb-1">${escapeHtml(report.report_type)}</h6>
                        <small class="text-muted">
                            <i class="bi bi-person-circle me-1"></i>${escapeHtml(report.username)}
                            <span class="mx-2">•</span>
                            <i class="bi bi-clock me-1"></i>${timeAgo}
                        </small>
                    </div>
                    <span class="badge bg-${statusClass}-subtle text-${statusClass} rounded-pill px-3">
                        ${report.report_status}
                    </span>
                </div>
                <p class="report-item-description text-secondary mb-2">
                    ${escapeHtml(report.report_description.substring(0, 120))}${report.report_description.length > 120 ? '...' : ''}
                </p>
                <div class="report-item-footer">
                    <span class="text-muted small">
                        <i class="bi bi-chat-dots me-1"></i>${report.message_count} ${report.message_count === 1 ? 'reply' : 'replies'}
                    </span>
                    <span class="text-primary small fw-medium">
                        View conversation <i class="bi bi-arrow-right"></i>
                    </span>
                </div>
            </div>
        `;
    }).join('');
}

function openChat(reportID) {
    currentReportID = reportID;
    
    if (chatRefreshInterval) {
        clearInterval(chatRefreshInterval);
    }
    
    fetch(`/QTrace-Website/database/controllers/get_report_chat.php?report_id=${reportID}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayChatInterface(data.parent, data.messages);
                
                chatRefreshInterval = setInterval(() => {
                    refreshChat();
                }, 5000);
            } else {
                alert('Failed to load chat: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error loading chat:', error);
            alert('Error loading chat. Please try again.');
        });
}

function displayChatInterface(parent, messages) {
    const chatContainer = document.getElementById('reportChatContainer');
    const chatTitle = document.getElementById('chatTitle');
    const chatStatus = document.getElementById('chatStatus');
    const messagesContainer = document.getElementById('chatMessages');
        chatTitle.textContent = parent.report_type;
    
    const statusClass = {
        'open': 'warning',
        'in progress': 'info',
        'resolved': 'success'
    }[parent.report_status] || 'secondary';
    
    chatStatus.className = `badge bg-${statusClass}-subtle text-${statusClass} rounded-pill px-3`;
    chatStatus.textContent = parent.report_status;
    
    const statusControls = document.getElementById('statusControls');
    if (isUserAdmin && parent.report_status !== 'resolved') {
        statusControls.innerHTML = `
            <div class="btn-group btn-group-sm ms-2">
                ${parent.report_status === 'open' ? `
                    <button class="btn btn-outline-info btn-sm" onclick="updateStatus('in progress')">
                        Mark In Progress
                    </button>
                ` : ''}
                <button class="btn btn-outline-success btn-sm" onclick="updateStatus('resolved')">
                    Mark Resolved
                </button>
            </div>
        `;
    } else {
        statusControls.innerHTML = '';
    }
    
    let messagesHTML = `
        <div class="message original-report">
            <div class="message-header">
                <strong>${escapeHtml(parent.username)}</strong>
                <span class="badge bg-primary-subtle text-primary ms-2">Original Report</span>
                <small class="text-muted ms-auto">${formatDateTime(parent.report_CreatedAt)}</small>
            </div>
            <div class="message-content">
                <p class="mb-2">${escapeHtml(parent.report_description)}</p>
                ${parent.report_evidencesPhoto_URL ? `
                    <div class="message-attachment">
                        <a href="${parent.report_evidencesPhoto_URL}" target="_blank">
                            <img src="${parent.report_evidencesPhoto_URL}" alt="Evidence" class="img-thumbnail" style="max-width: 300px;">
                        </a>
                    </div>
                ` : ''}
            </div>
        </div>
    `;
    
    messages.forEach(msg => {
        const isSystem = msg.user_ID === 0;
        const isAdmin = msg.user_role === 'admin';
        
        if (isSystem) {
            messagesHTML += `
                <div class="message system-message">
                    <div class="message-content text-center">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>${escapeHtml(msg.report_description)}
                        </small>
                    </div>
                </div>
            `;
        } else {
            messagesHTML += `
                <div class="message ${isAdmin ? 'admin-message' : 'user-message'}">
                    <div class="message-header">
                        <strong>${escapeHtml(msg.username)}</strong>
                        ${isAdmin ? '<span class="badge bg-danger-subtle text-danger ms-2">Admin</span>' : ''}
                        <small class="text-muted ms-auto">${formatDateTime(msg.report_CreatedAt)}</small>
                    </div>
                    <div class="message-content">
                        <p class="mb-0">${escapeHtml(msg.report_description)}</p>
                        ${msg.report_evidencesPhoto_URL ? `
                            <div class="message-attachment mt-2">
                                <a href="${msg.report_evidencesPhoto_URL}" target="_blank">
                                    <img src="${msg.report_evidencesPhoto_URL}" alt="Attachment" class="img-thumbnail" style="max-width: 200px;">
                                </a>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        }
    });
    
    messagesContainer.innerHTML = messagesHTML;
    
    chatContainer.style.display = 'block';
    
    scrollToBottom();
}

function refreshChat() {
    if (!currentReportID) return;
    
    fetch(`/QTrace-Website/database/controllers/get_report_chat.php?report_id=${currentReportID}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayChatInterface(data.parent, data.messages);
            }
        })
        .catch(error => {
            console.error('Error refreshing chat:', error);
        });
}

function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    
    if (!message || !currentReportID) return;
    
    const formData = new FormData();
    formData.append('parent_report_id', currentReportID);
    formData.append('message', message);
    
    messageInput.disabled = true;
    document.getElementById('sendMessageBtn').disabled = true;
    
    fetch('/QTrace-Website/database/controllers/add_chat_message.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            refreshChat();
        } else {
            alert('Failed to send message: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('Error sending message. Please try again.');
    })
    .finally(() => {
        messageInput.disabled = false;
        document.getElementById('sendMessageBtn').disabled = false;
        messageInput.focus();
    });
}

function updateStatus(newStatus) {
    if (!confirm(`Are you sure you want to mark this report as "${newStatus}"?`)) {
        return;
    }
    
    const formData = new FormData();
    formData.append('report_id', currentReportID);
    formData.append('status', newStatus);
    
    fetch('/QTrace-Website/database/controllers/update_report_status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            refreshChat();
            loadProjectReports();
        } else {
            alert('Failed to update status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error updating status:', error);
        alert('Error updating status. Please try again.');
    });
}
function closeChat() {
    document.getElementById('reportChatContainer').style.display = 'none';
    currentReportID = null;
    
    if (chatRefreshInterval) {
        clearInterval(chatRefreshInterval);
        chatRefreshInterval = null;
    }
}


function openReportModal() {
    const modal = new bootstrap.Modal(document.getElementById('newReportModal'));
    modal.show();
}

function submitNewReport() {
    const reportType = document.getElementById('reportType').value.trim();
    const description = document.getElementById('reportDescription').value.trim();
    const evidenceFile = document.getElementById('reportEvidence').files[0];
    
    if (!reportType) {
        alert('Please select a report type');
        return;
    }
    
    if (!description) {
        alert('Please provide a description');
        return;
    }
    
    const formData = new FormData();
    formData.append('project_id', currentProjectID);
    formData.append('report_type', reportType);
    formData.append('description', description);
    
    if (evidenceFile) {
        formData.append('evidence', evidenceFile);
    }
    
    // Disable button while submitting
    const submitBtn = document.getElementById('submitReportBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
    
    fetch('/QTrace-Website/database/controllers/add_report.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close
            bootstrap.Modal.getInstance(document.getElementById('newReportModal')).hide();
            
            // Reset 
            document.getElementById('reportType').value = '';
            document.getElementById('reportDescription').value = '';
            document.getElementById('reportEvidence').value = '';
            
            // Reload 
            loadProjectReports();
            
            // Show success message
            alert('Report submitted successfully!');
        } else {
            alert('Failed to submit report: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error submitting report:', error);
        alert('Error submitting report. Please try again.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-send me-2"></i>Submit Report';
    });
}

function updateReportCount(count) {
    const badge = document.querySelector('[data-bs-target="#reports"]');
    if (badge) {
        badge.innerHTML = `<i class="bi bi-chat-left-dots me-2"></i>Reports (${count})`;
    }
}

function scrollToBottom() {
    const container = document.getElementById('chatMessages');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
}

function formatDateTime(datetime) {
    const date = new Date(datetime);
    const now = new Date();
    const diff = now - date;
    
    // Less than 1 minute
    if (diff < 60000) {
        return 'Just now';
    }
    
    // Less than 1 hour
    if (diff < 3600000) {
        const minutes = Math.floor(diff / 60000);
        return `${minutes} ${minutes === 1 ? 'minute' : 'minutes'} ago`;
    }
    
    // Less than 24 hours
    if (diff < 86400000) {
        const hours = Math.floor(diff / 3600000);
        return `${hours} ${hours === 1 ? 'hour' : 'hours'} ago`;
    }
    
    // Format as date and time
    return date.toLocaleDateString() + ' at ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
}

/**
 * Get human-readable time ago
 */
function getTimeAgo(datetime) {
    return formatDateTime(datetime);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
