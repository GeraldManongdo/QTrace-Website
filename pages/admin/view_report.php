<?php
$page_name = 'reports';
require_once(__DIR__ . '/../../database/connection/connection.php');

$reportId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($reportId <= 0) {
    header('Location: /QTrace-Website/pages/admin/reports.php');
    exit();
}

$sql = "SELECT 
            r.report_ID,
            r.Project_ID,
            r.user_ID,
            r.report_type,
            r.report_description,
            r.report_evidencesPhoto_URL,
            r.report_status,
            r.report_CreatedAt,
            pd.ProjectDetails_Title,
            p.Project_Status,
            u.user_firstName AS FirstName,
            u.user_lastName AS LastName,
            u.user_Email,
            u.user_Role
        FROM report_table r
        LEFT JOIN projects_table p ON r.Project_ID = p.Project_ID
        LEFT JOIN projectdetails_table pd ON p.Project_ID = pd.Project_ID
        LEFT JOIN user_table u ON r.user_ID = u.user_ID
        WHERE r.report_ID = ? AND r.reportParent_ID IS NULL
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $reportId);
$stmt->execute();
$result = $stmt->get_result();
$report = $result->fetch_assoc();
$stmt->close();

if (!$report) {
    header('Location: /QTrace-Website/pages/admin/reports.php');
    exit();
}

include(__DIR__ . '/../../database/connection/security.php');

function formatStatusBadge(string $status): array {
    $key = strtolower($status);
    if ($key === 'resolved') return ['status-pill bg-success-subtle text-success', 'Resolved'];
    if ($key === 'in progress') return ['status-pill bg-warning-subtle text-warning', 'In Review'];
    return ['status-pill bg-primary-subtle text-primary', 'Pending'];
}

[$statusClass, $statusLabel] = formatStatusBadge($report['report_status'] ?? 'open');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Review report details and reply to users." />
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Report Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <style>
        body { background: #f7f9fb; }
        .card-soft { background: #fff; border: 1px solid #e6ebf1; border-radius: 12px; box-shadow: 0 6px 18px rgba(17, 24, 39, 0.08); }
        .section-heading { font-weight: 700; color: #111827; font-size: 1.05rem; }
        .label-muted { font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.08em; color: #6b7280; }
        .value-text { font-weight: 600; color: #111827; }
        .status-pill { border-radius: 999px; padding: 6px 12px; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 6px; }
        .description-box { background: #f3f6fb; border: 1px solid #e6ebf1; border-radius: 10px; padding: 12px 14px; min-height: 100px; color: #0f172a; }
        .evidence-thumb { max-width: 500px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08); }
        .timeline-dot { width: 14px; height: 14px; border-radius: 50%; background: #16a34a; display: inline-block; }
    </style>
</head>
<body>
    <div class="app-container">
        <?php include('../../components/header.php'); ?>

        <div class="content-area">
            <?php include('../../components/sideNavigation.php'); ?>

            <main class="main-view">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/QTrace-Website/dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="/QTrace-Website/pages/admin/reports.php">Report List</a></li>
                            <li class="breadcrumb-item active">RPT-<?php echo str_pad($report['report_ID'], 3, '0', STR_PAD_LEFT); ?></li>
                        </ol>
                    </nav>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="fw-bold mb-0">Report Details</h3>
                            <small class="text-muted">View and manage report information</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a class="btn btn-outline-secondary" href="/QTrace-Website/pages/admin/reports.php">Back to List</a>
                            <button class="btn btn-primary" onclick="openChatModal(<?php echo $reportId; ?>)"><i class="bi bi-reply-fill me-1"></i>Reply</button>
                            <button class="btn btn-light border" onclick="updateStatus('in progress')">Update Status</button>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card card-soft p-4 mb-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <div class="label-muted">Report ID</div>
                                        <div class="d-flex align-items-center gap-2 value-text">RPT-<?php echo str_pad($report['report_ID'], 3, '0', STR_PAD_LEFT); ?></div>
                                    </div>
                                    <span class="<?php echo $statusClass; ?>"><?php echo $statusLabel; ?></span>
                                </div>

                                <div class="mb-3">
                                    <div class="label-muted">Report Type</div>
                                    <div class="value-text"><?php echo htmlspecialchars($report['report_type'] ?? 'N/A'); ?></div>
                                </div>

                                <div class="mb-3">
                                    <div class="label-muted">Description</div>
                                    <div class="description-box"><?php echo nl2br(htmlspecialchars($report['report_description'] ?? '')); ?></div>
                                </div>

                                <?php if (!empty($report['report_evidencesPhoto_URL'])): ?>
                                <div class="mb-3">
                                    <div class="label-muted mb-2">Evidence Photos (1)</div>
                                    <img src="<?php echo htmlspecialchars($report['report_evidencesPhoto_URL']); ?>" alt="Evidence" class="evidence-thumb">
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="card card-soft p-4">
                                <div class="section-heading mb-3">Activity Timeline</div>
                                <div class="d-flex align-items-start gap-3">
                                    <span class="timeline-dot"></span>
                                    <div>
                                        <div class="value-text">Report Created</div>
                                        <small class="text-muted"><?php echo date('F d, Y \a\t h:i A', strtotime($report['report_CreatedAt'])); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card card-soft p-4 mb-4">
                                <div class="section-heading mb-3">Project Information</div>
                                <div class="mb-3">
                                    <div class="label-muted">Project ID</div>
                                    <div class="value-text">PRJ-<?php echo date('Y', strtotime($report['report_CreatedAt'])); ?>-<?php echo str_pad($report['Project_ID'], 3, '0', STR_PAD_LEFT); ?></div>
                                </div>
                                <div class="mb-3">
                                    <div class="label-muted">Project Name</div>
                                    <div class="value-text"><?php echo htmlspecialchars($report['ProjectDetails_Title'] ?? ''); ?></div>
                                </div>
                                <div>
                                    <div class="label-muted">Project Status</div>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3"><?php echo htmlspecialchars($report['Project_Status'] ?? ''); ?></span>
                                </div>
                            </div>

                            <div class="card card-soft p-4 mb-4">
                                <div class="section-heading mb-3">Reporter Information</div>
                                <div class="mb-3">
                                    <div class="label-muted">User ID</div>
                                    <div class="value-text">USR-<?php echo $report['user_ID']; ?></div>
                                </div>
                                <div class="mb-3">
                                    <div class="label-muted">Name</div>
                                    <div class="value-text"><?php echo htmlspecialchars(trim(($report['FirstName'] ?? '') . ' ' . ($report['LastName'] ?? ''))); ?></div>
                                </div>
                                <div>
                                    <div class="label-muted">Email</div>
                                    <div class="value-text"><?php echo htmlspecialchars($report['user_Email'] ?? ''); ?></div>
                                </div>
                            </div>

                            <div class="card card-soft p-4">
                                <div class="section-heading mb-3">Additional Details</div>
                                <div class="mb-3">
                                    <div class="label-muted">Created Date</div>
                                    <div class="value-text"><?php echo date('F d, Y \a\t h:i A', strtotime($report['report_CreatedAt'])); ?></div>
                                </div>
                                <div>
                                    <div class="label-muted">Priority</div>
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Not set</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Chat Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conversation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="chatHistory">
                        <div class="text-center py-5">
                            <div class="spinner-border" style="color: var(--primary);" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Your reply</label>
                        <textarea class="form-control" id="replyInput" rows="3" placeholder="Type your message..."></textarea>
                        <div class="d-flex justify-content-end mt-2">
                            <button class="btn bg-color-primary text-white" id="sendReplyBtn" onclick="sendReply(<?php echo $reportId; ?>)"><i class="bi bi-send me-1"></i>Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function updateStatus(newStatus) {
        if (!confirm(`Mark this report as "${newStatus}"?`)) return;

        const reportId = <?php echo $reportId; ?>;
        const formData = new FormData();
        formData.append('report_id', reportId);
        formData.append('status', newStatus);

        fetch('/QTrace-Website/database/controllers/update_report_status.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to update status');
            }
        })
        .catch(() => alert('Error updating status'));
    }

    function openChatModal(reportId) {
        const modal = new bootstrap.Modal(document.getElementById('chatModal'));
        modal.show();
        fetch(`/QTrace-Website/database/controllers/get_report_chat.php?report_id=${reportId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    renderChat(data.parent, data.messages);
                } else {
                    document.getElementById('chatHistory').innerHTML = '<div class="alert alert-danger">Failed to load conversation.</div>';
                }
            })
            .catch(() => {
                document.getElementById('chatHistory').innerHTML = '<div class="alert alert-danger">Error loading conversation.</div>';
            });
    }

    function renderChat(parent, messages) {
        const isParentAdmin = parent.user_role && parent.user_role.toLowerCase() === 'admin';
        let html = `
            <div class="alert alert-primary">
                <small class="text-muted">${parent.username}${isParentAdmin ? ' <span class="badge bg-danger">Admin</span>' : ' <span class="badge bg-secondary">Citizen</span>'} <span class="badge bg-primary-subtle text-primary ms-1">Original Report</span> • ${new Date(parent.report_CreatedAt).toLocaleString()}</small>
                <p class="mt-2 mb-0">${escapeHtml(parent.report_description)}</p>
                ${parent.report_evidencesPhoto_URL ? `<div class="mt-2"><img src="${parent.report_evidencesPhoto_URL}" class="img-thumbnail" style="max-width: 240px;"></div>` : ''}
            </div>
        `;
        if (messages.length > 0) {
            messages.forEach(msg => {
                const isAdmin = msg.user_role && msg.user_role.toLowerCase() === 'admin';
                console.log('Message from:', msg.username, 'Role:', msg.user_role, 'Is Admin:', isAdmin);
                const alertClass = isAdmin ? 'alert-warning' : 'alert-light';
                html += `
                    <div class="alert ${alertClass} mt-2">
                        <small class="text-muted">${msg.username}${isAdmin ? ' <span class="badge bg-danger">Admin</span>' : ' <span class="badge bg-secondary">Citizen</span>'} • ${new Date(msg.report_CreatedAt).toLocaleString()}</small>
                        <p class="mt-1 mb-0">${escapeHtml(msg.report_description)}</p>
                    </div>
                `;
            });
        } else {
            html += '<div class="alert alert-secondary">No replies yet</div>';
        }
        document.getElementById('chatHistory').innerHTML = html;
    }

    function sendReply(parentId) {
        const textarea = document.getElementById('replyInput');
        const message = textarea.value.trim();
        if (!message) return;
        document.getElementById('sendReplyBtn').disabled = true;
        const formData = new FormData();
        formData.append('parent_report_id', parentId);
        formData.append('message', message);
        fetch('/QTrace-Website/database/controllers/add_chat_message.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                textarea.value = '';
                // Reload chat content without reopening modal
                fetch(`/QTrace-Website/database/controllers/get_report_chat.php?report_id=${parentId}`)
                    .then(res => res.json())
                    .then(chatData => {
                        if (chatData.success) {
                            renderChat(chatData.parent, chatData.messages);
                        }
                    });
            } else {
                alert(data.message || 'Failed to send message');
            }
        })
        .catch(() => alert('Error sending message'))
        .finally(() => { document.getElementById('sendReplyBtn').disabled = false; });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    </script>

    <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
