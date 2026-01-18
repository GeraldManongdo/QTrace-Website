        const map = L.map('map', {
            center: [14.6760, 121.0437],
            zoom: 13,
            zoomControl: false
        });
        
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const markerLayer = L.layerGroup().addTo(map);

        function getStatusColor(status) {
            const colors = {
                'Planning': '#0d6efd',
                'Ongoing': '#198754',
                'Delayed': '#dc3545',
                'Completed': '#6c757d'
            };
            return colors[status] || '#333';
        }

        function renderDashboard(data) {
            const listArea = document.getElementById('projectList');
            const countLabel = document.getElementById('projectCount');
            
            listArea.innerHTML = '';
            markerLayer.clearLayers();
            countLabel.innerText = data.length;

            data.forEach(proj => {
                // Formatting currency
                const budgetFormatted = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(proj.ProjectDetails_Budget);
                const address = `${proj.ProjectDetails_Street}, ${proj.ProjectDetails_Barangay}`;

                // 1. Create Sidebar Item
                const card = document.createElement('div');
                card.className = 'project-item p-4';
                card.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <span class="title fs-6 mb-1 fw-medium">${proj.ProjectDetails_Title}</span>
                    </div>
                    <div class="meta fs-8 text-muted"><i class="bi bi-geo-alt"></i> ${address}</div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fw-bold small" style="color: var(--accent);">${budgetFormatted}</span>
                        <span class="badge" style="background-color: ${getStatusColor(proj.Project_Status)}">${proj.Project_Status}</span>
                    </div>
                `;
                card.onclick = () => {
                    map.flyTo([proj.Project_Lat, proj.Project_Lng], 16);
                    openPopup(proj);
                };
                listArea.appendChild(card);

                // 2. Create Map Pin
                const pinIcon = L.divIcon({
                    html: `<i class="bi bi-geo-alt-fill" style="color: ${getStatusColor(proj.Project_Status)};"></i>`,
                    className: 'custom-pin',
                    iconSize: [30, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -32]
                });

                L.marker([proj.Project_Lat, proj.Project_Lng], { icon: pinIcon })
                    .addTo(markerLayer)
                    .on('click', () => openPopup(proj));
            });
        }

        function openPopup(proj) {
            const budgetFormatted = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(proj.ProjectDetails_Budget);
            const targetPath = (userRole === 'admin') 
                ? '/QTrace-Website/view-project' 
                : '/QTrace-Website/project-details';
            const content = `
                <div class="p-1" style="min-width: 220px;">
                    <h6 class="fw-bold mb-0">${proj.ProjectDetails_Title}</h6>
                    <p class="text-muted mb-2 ">${proj.ProjectDetails_Street}, ${proj.ProjectDetails_Barangay}</p>
                    <table class="table table-borderless table-sm mb-2" style="font-size: 0.75rem;">
                        <tr><td><strong>Status:</strong></td><td>${proj.Project_Status}</td></tr>
                        <tr><td><strong>Budget:</strong></td><td>${budgetFormatted}</td></tr>
                        <tr><td><strong>Start:</strong></td><td>${proj.ProjectDetails_StartedDate}</td></tr>
                    </table>
                    <button class="btn btn-primary btn-sm w-100 py-2 fw-bold" onclick="window.location.href='${targetPath}?id=${proj.Project_ID}'">View Details</button>
                </div>
            `;
            L.popup().setLatLng([proj.Project_Lat, proj.Project_Lng]).setContent(content).openOn(map);
        }

        function applyFilters() {
            // 1. Get current values from both dropdowns
            const statusValue = document.getElementById('statusFilter').value;
            const categoryValue = document.getElementById('categoryFilter').value;
            
            // 2. Filter the master projects array
            const filtered = projects.filter(p => {
                // Condition for Status
                const matchesStatus = (statusValue === 'all' || p.Project_Status === statusValue);
                
                // Condition for Category
                const matchesCategory = (categoryValue === 'all' || p.Project_Category === categoryValue);
                
                // Return true only if BOTH match
                return matchesStatus && matchesCategory;
            });

            // 3. Re-render the UI with the filtered list
            renderDashboard(filtered);
        }

        // Attach event listeners to both dropdowns
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('categoryFilter').addEventListener('change', applyFilters);

        // Reset functionality
        document.getElementById('clearFilters').addEventListener('click', () => {
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('categoryFilter').value = 'all';
            renderDashboard(projects);
        });

        renderDashboard(projects);