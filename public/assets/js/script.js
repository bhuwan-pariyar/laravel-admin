// start: Sidebar
const sidebarToggleTrigger = document.querySelector(".sidebar-toggle");
const sidebarOverlay = document.querySelector(".sidebar-overlay");
const sidebarMenu = document.querySelector(".sidebar-menu");
const main = document.querySelector(".main");

// Elements for icon and logo swapping
const sidebarToggleBtn = document.getElementById("sidebarToggle");
const iconIndent = document.getElementById("sidebarIconIndent");
const iconOutdent = document.getElementById("sidebarIconOutdent");
const logoExpanded = document.getElementById("logoExpanded");
const logoCollapsed = document.getElementById("logoCollapsed");

// Only run sidebar code if elements exist
if (sidebarToggleTrigger && sidebarOverlay && sidebarMenu && main) {
    // Desktop sidebar toggle (expand/collapse)
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener("click", function (e) {
            e.preventDefault();

            if (sidebarMenu.classList.contains("collapsed")) {
                // Currently collapsed, go to expanded
                sidebarMenu.classList.remove("collapsed");
                main.classList.remove("collapsed");

                // Swap icons and logos
                if (iconIndent && iconOutdent) {
                    iconIndent.classList.remove("hidden");
                    iconOutdent.classList.add("hidden");
                }
                if (logoExpanded && logoCollapsed) {
                    logoExpanded.classList.remove("hidden");
                    logoCollapsed.classList.add("hidden");
                }
            } else {
                // Currently expanded, go to collapsed
                sidebarMenu.classList.add("collapsed");
                main.classList.add("collapsed");

                // Swap icons and logos
                if (iconIndent && iconOutdent) {
                    iconIndent.classList.add("hidden");
                    iconOutdent.classList.remove("hidden");
                }
                if (logoExpanded && logoCollapsed) {
                    logoExpanded.classList.add("hidden");
                    logoCollapsed.classList.remove("hidden");
                }
            }

            // Re-initialize popup handlers after state change
            setTimeout(function () {
                initializeCollapsedSidebarPopups();
                window.dispatchEvent(new Event("sidebarStateChanged"));
            }, 100);
        });
    }

    // Mobile sidebar toggle (uses same trigger class)
    sidebarToggleTrigger.addEventListener("click", function (e) {
        e.preventDefault();
        if (window.innerWidth < 768) {
            main.classList.toggle("active");
            sidebarOverlay.classList.toggle("hidden");
            sidebarMenu.classList.toggle("-translate-x-full");
        }
    });

    sidebarOverlay.addEventListener("click", function (e) {
        e.preventDefault();
        main.classList.add("active");
        sidebarOverlay.classList.add("hidden");
        sidebarMenu.classList.add("-translate-x-full");
    });

    // Dropdown toggle for expanded sidebar
    document
        .querySelectorAll(".sidebar-dropdown-toggle")
        .forEach(function (item) {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                const parent = item.closest(".group");
                const sidebar = parent.closest(".sidebar-menu");

                // Only handle dropdown if sidebar is fully expanded (not collapsed)
                if (sidebar && !sidebar.classList.contains("collapsed")) {
                    if (parent.classList.contains("selected")) {
                        parent.classList.remove("selected");
                    } else {
                        document
                            .querySelectorAll(".sidebar-dropdown-toggle")
                            .forEach(function (i) {
                                i.closest(".group").classList.remove(
                                    "selected"
                                );
                            });
                        parent.classList.add("selected");
                    }
                }
            });
        });
}

// Function to initialize collapsed sidebar popup behavior
function initializeCollapsedSidebarPopups() {
    const sidebar = document.getElementById("sidebar");
    // Only initialize popups if sidebar is in collapsed state
    if (!sidebar || !sidebar.classList.contains("collapsed")) {
        // Clean up if sidebar is expanded
        const allItems = document.querySelectorAll(
            ".has-children, .no-children"
        );
        allItems.forEach(function (item) {
            item.classList.remove("show-popup", "show-tooltip");
        });
        return;
    }

    const hasChildrenItems = sidebar.querySelectorAll(".has-children");

    // Remove old event listeners by storing them
    hasChildrenItems.forEach(function (item) {
        const parentLink = item.querySelector("a");
        const submenu = item.querySelector("ul");

        if (parentLink && submenu) {
            let hoverTimeout;
            let leaveTimeout;

            // Clear any existing timeouts
            clearTimeout(hoverTimeout);
            clearTimeout(leaveTimeout);

            // Remove old listeners by using a flag
            item._popupInitialized = true;

            // Mouse enter on parent item - show popup
            const handleMouseEnter = function (e) {
                clearTimeout(leaveTimeout);

                hoverTimeout = setTimeout(function () {
                    // Calculate position relative to viewport
                    const rect = item.getBoundingClientRect();
                    if (submenu) {
                        // Position popup aligned with top of parent item
                        let topPosition = rect.top;

                        // Set left position for collapsed sidebar
                        submenu.style.left = "4rem";

                        // Check if popup would go off bottom of screen
                        const submenuHeight = submenu.offsetHeight || 200; // Estimate if not rendered
                        const viewportHeight = window.innerHeight;
                        if (topPosition + submenuHeight > viewportHeight) {
                            // Adjust to fit on screen
                            topPosition = viewportHeight - submenuHeight - 10;
                        }

                        // Ensure popup doesn't go above viewport
                        if (topPosition < 10) {
                            topPosition = 10;
                        }

                        submenu.style.top = topPosition + "px";
                        item.classList.add("show-popup");
                    }
                }, 150);
            };

            // Mouse leave from parent item - hide popup with delay
            const handleMouseLeave = function (e) {
                clearTimeout(hoverTimeout);

                // Check if mouse is moving to submenu
                const relatedTarget = e.relatedTarget;
                if (
                    relatedTarget &&
                    submenu &&
                    (submenu.contains(relatedTarget) ||
                        submenu === relatedTarget)
                ) {
                    return; // Don't hide if moving to submenu
                }

                leaveTimeout = setTimeout(function () {
                    item.classList.remove("show-popup");
                }, 200);
            };

            // Remove old listeners if they exist
            if (item._mouseEnterHandler) {
                item.removeEventListener("mouseenter", item._mouseEnterHandler);
            }
            if (item._mouseLeaveHandler) {
                item.removeEventListener("mouseleave", item._mouseLeaveHandler);
            }

            // Store handlers for cleanup
            item._mouseEnterHandler = handleMouseEnter;
            item._mouseLeaveHandler = handleMouseLeave;

            // Add new listeners
            item.addEventListener("mouseenter", handleMouseEnter);
            item.addEventListener("mouseleave", handleMouseLeave);

            // Keep popup visible when hovering over submenu
            const handleSubmenuEnter = function (e) {
                clearTimeout(leaveTimeout);
                item.classList.add("show-popup");
            };

            const handleSubmenuLeave = function (e) {
                leaveTimeout = setTimeout(function () {
                    item.classList.remove("show-popup");
                }, 200);
            };

            // Remove old submenu listeners if they exist
            if (submenu._submenuEnterHandler) {
                submenu.removeEventListener(
                    "mouseenter",
                    submenu._submenuEnterHandler
                );
            }
            if (submenu._submenuLeaveHandler) {
                submenu.removeEventListener(
                    "mouseleave",
                    submenu._submenuLeaveHandler
                );
            }

            // Store submenu handlers
            submenu._submenuEnterHandler = handleSubmenuEnter;
            submenu._submenuLeaveHandler = handleSubmenuLeave;

            // Add submenu listeners
            submenu.addEventListener("mouseenter", handleSubmenuEnter);
            submenu.addEventListener("mouseleave", handleSubmenuLeave);
        }
    });

    // Handle tooltips for items without children (only in collapsed state)
    const noChildrenItems = sidebar.querySelectorAll(".no-children");
    noChildrenItems.forEach(function (item) {
        let tooltipTimeout;
        let tooltipLeaveTimeout;

        // Remove old listeners
        if (item._tooltipEnterHandler) {
            item.removeEventListener("mouseenter", item._tooltipEnterHandler);
        }
        if (item._tooltipLeaveHandler) {
            item.removeEventListener("mouseleave", item._tooltipLeaveHandler);
        }

        const handleTooltipEnter = function () {
            clearTimeout(tooltipLeaveTimeout);
            tooltipTimeout = setTimeout(function () {
                item.classList.add("show-tooltip");
            }, 150);
        };

        const handleTooltipLeave = function () {
            clearTimeout(tooltipTimeout);
            tooltipLeaveTimeout = setTimeout(function () {
                item.classList.remove("show-tooltip");
            }, 100);
        };

        // Store handlers
        item._tooltipEnterHandler = handleTooltipEnter;
        item._tooltipLeaveHandler = handleTooltipLeave;

        // Add listeners
        item.addEventListener("mouseenter", handleTooltipEnter);
        item.addEventListener("mouseleave", handleTooltipLeave);
    });
}

// Initialize on page load if sidebar is collapsed
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(initializeCollapsedSidebarPopups, 100);
});

// Re-initialize when sidebar state changes
window.addEventListener("sidebarStateChanged", function () {
    setTimeout(initializeCollapsedSidebarPopups, 100);
});
// end: Sidebar

// start: Popper
const popperInstance = {};
document.querySelectorAll(".dropdown").forEach(function (item, index) {
    const popperId = "popper-" + index;
    const toggle = item.querySelector(".dropdown-toggle");
    const menu = item.querySelector(".dropdown-menu");
    menu.dataset.popperId = popperId;
    popperInstance[popperId] = Popper.createPopper(toggle, menu, {
        modifiers: [
            {
                name: "offset",
                options: {
                    offset: [0, 12], // Increased from 8 to 12 for more space
                },
            },
            {
                name: "preventOverflow",
                options: {
                    padding: 8,
                    boundary: "clippingParents",
                },
            },
            {
                name: "flip",
                options: {
                    fallbackPlacements: [
                        "bottom-start",
                        "top-end",
                        "top-start",
                    ],
                },
            },
        ],
        placement: "bottom-end",
        strategy: "absolute", // Ensures consistent positioning
    });
});

document.addEventListener("click", function (e) {
    const toggle = e.target.closest(".dropdown-toggle");
    const menu = e.target.closest(".dropdown-menu");
    if (toggle) {
        const menuEl = toggle
            .closest(".dropdown")
            .querySelector(".dropdown-menu");
        const popperId = menuEl.dataset.popperId;
        if (menuEl.classList.contains("hidden")) {
            hideDropdown();
            menuEl.classList.remove("hidden");
            showPopper(popperId);
        } else {
            menuEl.classList.add("hidden");
            hidePopper(popperId);
        }
    } else if (!menu) {
        hideDropdown();
    }
});

function hideDropdown() {
    document.querySelectorAll(".dropdown-menu").forEach(function (item) {
        item.classList.add("hidden");
    });
}
function showPopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: "eventListeners", enabled: true },
            ],
        };
    });
    popperInstance[popperId].update();
}
function hidePopper(popperId) {
    popperInstance[popperId].setOptions(function (options) {
        return {
            ...options,
            modifiers: [
                ...options.modifiers,
                { name: "eventListeners", enabled: false },
            ],
        };
    });
}
// end: Popper

// start: Tab
document.querySelectorAll("[data-tab]").forEach(function (item) {
    item.addEventListener("click", function (e) {
        e.preventDefault();
        const tab = item.dataset.tab;
        const page = item.dataset.tabPage;
        const target = document.querySelector(
            '[data-tab-for="' + tab + '"][data-page="' + page + '"]'
        );
        document
            .querySelectorAll('[data-tab="' + tab + '"]')
            .forEach(function (i) {
                i.classList.remove("active");
            });
        document
            .querySelectorAll('[data-tab-for="' + tab + '"]')
            .forEach(function (i) {
                i.classList.add("hidden");
            });
        item.classList.add("active");
        target.classList.remove("hidden");
    });
});
// end: Tab

// start: Chart
const orderChart = document.getElementById("order-chart");
if (orderChart) {
    new Chart(orderChart, {
        type: "line",
        data: {
            labels: generateNDays(7),
            datasets: [
                {
                    label: "Active",
                    data: generateRandomData(7),
                    borderWidth: 1,
                    fill: true,
                    pointBackgroundColor: "rgb(59, 130, 246)",
                    borderColor: "rgb(59, 130, 246)",
                    backgroundColor: "rgb(59 130 246 / .05)",
                    tension: 0.2,
                },
                {
                    label: "Completed",
                    data: generateRandomData(7),
                    borderWidth: 1,
                    fill: true,
                    pointBackgroundColor: "rgb(16, 185, 129)",
                    borderColor: "rgb(16, 185, 129)",
                    backgroundColor: "rgb(16 185 129 / .05)",
                    tension: 0.2,
                },
                {
                    label: "Canceled",
                    data: generateRandomData(7),
                    borderWidth: 1,
                    fill: true,
                    pointBackgroundColor: "rgb(244, 63, 94)",
                    borderColor: "rgb(244, 63, 94)",
                    backgroundColor: "rgb(244 63 94 / .05)",
                    tension: 0.2,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}

function generateNDays(n) {
    const data = [];
    for (let i = 0; i < n; i++) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        data.push(
            date.toLocaleString("en-US", {
                month: "short",
                day: "numeric",
            })
        );
    }
    return data;
}
function generateRandomData(n) {
    const data = [];
    for (let i = 0; i < n; i++) {
        data.push(Math.round(Math.random() * 10));
    }
    return data;
}
// end: Chart
