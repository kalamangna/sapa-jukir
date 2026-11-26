<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    @php
        $layoutRoleLabel = auth()->check() && auth()->user()->role === 'pimpinan'
            ? 'Pimpinan'
            : 'Administrator';
    @endphp

    <x-seo :title="trim($__env->yieldContent('title', $layoutRoleLabel)).' | SAPA JUKIR Sinjai'" :noindex="true" />


    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    {{-- Custom Style --}}
    <style>

        :root {

            --sidebar-width: 260px;

            --primary: #1a5dff;
            --primary-dark: #0d2f8d;

            --sidebar-bg: #0b2342;
            --content-bg: #f5f7fb;

            --border-color: #e4e9f2;

        }


        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            overflow-x: hidden;

            font-family:
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background: var(--content-bg);

            color: #212529;

        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        */

        .sidebar {

            position: fixed;

            top: 0;
            left: 0;

            width: var(--sidebar-width);

            height: 100vh;

            background:
                radial-gradient(ellipse at 12% 0%, rgba(108, 144, 176, 0.16), transparent 38%),
                linear-gradient(160deg, #0d2b4d 0%, #0b2342 48%, #081b33 100%);

            border-right:
                1px solid var(--border-color);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 12px 0 36px rgba(13, 30, 50, 0.18);

            display: flex;

            flex-direction: column;

            z-index: 1000;

        }


        /*
        |--------------------------------------------------------------------------
        | BRAND
        |--------------------------------------------------------------------------
        */

        .sidebar-brand {

            min-height: 68px;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 0 16px;

            border-bottom:
                1px solid var(--border-color);
            border-color: rgba(255, 255, 255, 0.1);

        }


        .brand-icon {
           width: 42px;
           height: 42px;
           border: 1px solid rgba(255, 255, 255, 0.2);
           border-radius: 10px;
           background: rgba(255, 255, 255, 0.1);
           color: white;
           display: flex;
           align-items: center;
           justify-content: center;
           font-size: 20px;
        }

        /* CSS LOGO BARU */
        .brand-icon img {
          width: 32px;
          height: 32px;
          object-fit: contain;
          display: block;
        
        }
        
        .brand-text h5 {

            margin: 0;

            font-weight: 700;

            font-size: 16px;
            letter-spacing: 0.08em;
            color: #fff;

        }


        .brand-text small {

            color: #b8c9dc;

            font-size: 12px;

        }

        .sidebar-toggle {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            padding: 0;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.08);
            color: #d7e3ef;
            cursor: pointer;
            flex-shrink: 0;
        }

        .sidebar-toggle:hover {
            color: #fff;
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.16);
        }

        .sidebar-user-card {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 11px;
            margin: 12px 12px 5px;
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.06);
            color: #f3f4f6;
        }

        .sidebar-user-avatar {
            display: flex;
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 50%;
            background: linear-gradient(145deg, #078f83, #315c75);
            color: #fff;
            font-size: 13px;
            font-weight: 800;
        }

        .sidebar-user-copy {
            min-width: 0;
            line-height: 1.35;
        }

        .sidebar-user-name,
        .sidebar-user-role {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar-user-name {
            color: #fff;
            font-size: 12px;
            font-weight: 700;
        }

        .sidebar-user-role {
            margin-top: 3px;
            color: #aebed0;
            font-size: 10px;
            font-weight: 500;
        }


        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        */

        .sidebar-menu {

            flex: 1;

            padding: 8px 12px 14px;

            overflow-y: auto;
            overflow-x: hidden;

        }


        .menu-label {

            font-size: 11px;

            font-weight: 700;

            color: #9aabbb;

            text-transform: uppercase;

            letter-spacing: 1px;

            margin: 12px 0 5px;
            padding: 10px 12px 5px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);

        }

        .menu-label:first-child {
            margin-top: 2px;
            border-top: 0;
        }


        .sidebar-menu a {

            display: flex;

            align-items: center;

            gap: 12px;

            min-height: 42px;
            padding: 8px 12px;

            margin-bottom: 4px;

            text-decoration: none;

            color: #c1cfde;

            border-radius: 9px;

            transition: 0.2s;

            font-size: 13px;

            font-weight: 500;

        }

        .sidebar-footer {
            flex: 0 0 auto;
            padding: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.12);
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 11px 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.06);
            color: #c1cfde;
            font-weight: 600;
            text-align: left;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .sidebar-logout:hover {
            border-color: rgba(239, 35, 60, 0.45);
            background: rgba(239, 35, 60, 0.14);
            color: #ffc1c8;
        }

        .sidebar-logout i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.1);
            font-size: 18px;
        }


        .sidebar-menu a:hover {

            background: rgba(255, 255, 255, 0.08);

            color: white;

        }


        .sidebar-menu a.active {

            background: #078f83;

            color: white;
            box-shadow: 0 5px 14px rgba(0, 184, 122, 0.2);

        }


        .sidebar-menu i {

            display: inline-flex;
            width: 28px;
            height: 28px;
            flex: 0 0 28px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.09);
            font-size: 15px;

        }

        .sidebar-menu a:hover i {
            background: rgba(255, 255, 255, 0.15);
        }

        .sidebar-menu a.active i {
            background: rgba(255, 255, 255, 0.18);
        }

        .dashboard-source-table-wrap {
            overflow-x: auto;
            scrollbar-width: auto;
        }

        .dashboard-source-table {
            min-width: 920px;
        }

        .dashboard-source-table-wrap::-webkit-scrollbar {
            height: 10px;
        }

        .dashboard-source-table-wrap::-webkit-scrollbar-thumb {
            background: #adb5bd;
            border-radius: 999px;
        }

        .dashboard-page .card-body > small {
            display: block;
            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | MAIN CONTENT
        |--------------------------------------------------------------------------
        */

        .main {

            margin-left: var(--sidebar-width);

        }

        @media (min-width: 992px) {
            body.sidebar-collapsed .sidebar {
                width: 70px;
            }

            body.sidebar-collapsed .main {
                margin-left: 70px;
            }

            body.sidebar-collapsed .sidebar-brand {
                justify-content: center;
                padding: 0;
            }

            body.sidebar-collapsed .brand-text,
            body.sidebar-collapsed .sidebar-user-copy,
            body.sidebar-collapsed .menu-label,
            body.sidebar-collapsed .sidebar-menu a span,
            body.sidebar-collapsed .sidebar-logout span {
                display: none;
            }

            body.sidebar-collapsed .sidebar-user-card {
                justify-content: center;
                margin: 12px 8px 5px;
                padding: 7px 0;
            }

            body.sidebar-collapsed .sidebar-menu a {
                justify-content: center;
                padding: 12px;
            }

            body.sidebar-collapsed .sidebar-footer {
                padding: 12px 8px;
            }

            body.sidebar-collapsed .sidebar-logout {
                justify-content: center;
                padding: 12px;
            }

            body.sidebar-collapsed .sidebar-toggle {
                position: absolute;
                right: -15px;
                top: 22px;
                background: #173b5f;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            }

            body.sidebar-collapsed .sidebar-toggle i {
                transform: rotate(180deg);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TOPBAR
        |--------------------------------------------------------------------------
        */

        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            min-height: 75px;
            height: auto;
            display: flex;
            align-items: center;
            padding: 10px 24px;
            background: transparent;
            border: 0;
        }

        .topbar-glass {
            display: flex;
            width: 100%;
            min-height: 56px;
            align-items: center;
            gap: 12px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, 0.82);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.82);
            box-shadow: 0 10px 28px rgba(67, 48, 31, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(18px) saturate(135%);
            -webkit-backdrop-filter: blur(18px) saturate(135%);
        }


        .topbar-title h5 {

            margin: 0;

            font-weight: 600;

        }


        .topbar-title small {

            color: #6c757d;

        }

        .topbar-greeting {
            min-width: 0;
            flex: 1 1 0;
            padding: 0 8px;
            color: #21314b;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.4;
            overflow-wrap: anywhere;
        }

        .topbar-greeting-word {
            display: inline-block;
            margin-right: 0.28em;
            animation: topbarGreetingReveal 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: calc(var(--word-index, 0) * 0.18s);
        }

        .topbar-greeting-word--exit {
            animation: topbarGreetingExit 0.35s ease both;
            animation-delay: calc(var(--word-index, 0) * 0.06s);
        }

        @keyframes topbarGreetingReveal {
            from {
                opacity: 0;
                transform: translateY(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes topbarGreetingExit {
            to {
                opacity: 0;
                transform: translateY(-5px);
            }
        }

        .admin-site.dark-theme .topbar-greeting {
            color: #e5e7eb;
        }

        .admin-site.dark-theme .topbar {
            background: transparent;
            border-color: transparent;
        }

        .admin-site.dark-theme .topbar-glass {
            border-color: rgba(255, 255, 255, 0.12);
            background: rgba(23, 28, 37, 0.86);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.28), inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .admin-notification {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.45rem;
            height: 2.45rem;
            flex: 0 0 2.45rem;
            margin: 0;
            border: 0;
            border-radius: 50%;
            background: #eef3ff;
            color: var(--primary-dark);
        }

        .admin-notification i {
            font-size: 1.1rem !important;
        }

        .admin-notification .badge {
            position: absolute;
            top: -2px;
            right: -1px;
            font-size: 10px;
        }


        .admin-profile {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .profile-avatar {

            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: var(--primary);

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: 700;

        }


        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .content {

            padding: 30px;

        }

        .global-alert {
            position: fixed;
            top: 96px;
            right: 24px;
            z-index: 1060;
            width: min(360px, calc(100vw - 32px));
            margin: 0;
            padding: 0.85rem 1rem;
            font-size: 0.9rem;
            border-radius: 12px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.14);
            opacity: 0;
            transform: translateY(-8px);
            animation: adminAlertIn 0.35s ease forwards;
        }

        .global-alert .btn-close {
            padding: 0.85rem;
        }

        .auto-dismiss-alert {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .auto-dismiss-alert.fade {
            opacity: 0;
            transform: translateY(-6px);
        }

        @keyframes adminAlertIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content table thead th,
        .content table tbody td {
            text-align: center;
        }

        .content table .text-start {
            text-align: left !important;
        }

        .content table .text-end {
            text-align: right !important;
        }

        .report-page .content table thead th,
        .report-page .content table tbody td,
        .report-page .content table .text-start,
        .report-page .content table .text-end {
            text-align: center !important;
        }


        /*
        |--------------------------------------------------------------------------
        | CARD
        |--------------------------------------------------------------------------
        */

        .card {

            border: none;

            border-radius: 12px;

            box-shadow:
                0 2px 10px
                rgba(0, 0, 0, 0.04);

        }

        .admin-site .btn-success {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .admin-site .btn-success:hover,
        .admin-site .btn-success:focus {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        .sidebar-overlay {
            display: none;
        }

        .mobile-sidebar-toggle {
            display: none;
        }

        @media (max-width: 991px) {
            .sidebar {
                width: min(85vw, 290px);
                transform: translateX(-100%);
                transition: transform 0.22s ease;
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                z-index: 999;
                border: 0;
                background: rgba(8, 27, 51, 0.48);
            }

            body.sidebar-open .sidebar-overlay {
                display: block;
            }

            .main {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: none;
            }

            .mobile-sidebar-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.45rem;
                height: 2.45rem;
                flex: 0 0 2.45rem;
                padding: 0;
                border: 1px solid var(--border-color);
                border-radius: 10px;
                background: #fff;
                color: var(--primary-dark);
                font-size: 20px;
            }

            .admin-site.dark-theme .mobile-sidebar-toggle {
                border-color: #173655;
                background: #1e293b;
                color: #e5e7eb;
            }

            .mobile-sidebar-toggle i {
                font-size: 1.1rem;
            }
        }


        @media (max-width: 576px) {

            .topbar {
                min-height: 64px;
                padding: 7px 10px;
            }

            .topbar-glass {
                min-height: 50px;
                gap: 6px;
                padding: 5px 7px;
            }

            .admin-notification,
            .admin-theme-toggle,
            .mobile-sidebar-toggle {
                width: 2.5rem;
                height: 2.5rem;
                flex-basis: 2.5rem;
            }

            .content .btn {
                min-height: 2.5rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .content .form-control,
            .content .form-select {
                min-height: 2.5rem;
            }

            .topbar-greeting {
                padding: 0 6px;
                font-size: 12px;
            }


            .content {

                padding: 20px 15px;

            }

            .global-alert {
                top: 74px;
                right: 15px;
                width: calc(100vw - 30px);
            }


            .topbar-title small {

                display: none;

            }

        }

        /* ==========================================================
   ADMIN PROFILE
========================================================== */

.admin-profile {
    position: relative;
    z-index: 1055;
}

.admin-profile-button {
    display: flex;
    align-items: center;
    gap: 12px;

    border: 0;
    background: transparent;

    padding: 6px 8px;

    cursor: pointer;

    color: inherit;
}

.admin-profile-button:hover {
    background: rgba(0, 0, 0, 0.04);
    border-radius: 10px;
}

.admin-profile-info {
    text-align: right;
    line-height: 1.25;
}

.profile-avatar {
    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: var(--primary);
    color: #ffffff;

    font-weight: 700;
    font-size: 16px;

    flex-shrink: 0;
}

.admin-profile-chevron {
    font-size: 11px;
    color: #6b7280;
    transition: transform 0.2s ease;
}

.admin-profile.show .admin-profile-chevron {
    transform: rotate(180deg);
}


/* ==========================================================
   DROPDOWN
========================================================== */

.admin-dropdown-menu {
    min-width: 270px;

    margin-top: 10px !important;

    padding: 8px;

    border: 1px solid #e5e7eb;
    border-radius: 12px;

    z-index: 9999;
}

.admin-dropdown-menu .dropdown-item {
    border-radius: 8px;
    padding: 10px 12px;
}

.admin-dropdown-menu .dropdown-item:hover {
    background: #f3f4f6;
}

.admin-dropdown-menu .dropdown-item.text-danger:hover {
    background: #fef2f2;
}

.admin-dropdown-header {
    display: flex;
    align-items: center;
    gap: 12px;

    padding: 10px 12px;
}

.admin-dropdown-avatar {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #dbeafe;
    color: var(--primary-dark);

    font-weight: 700;

    flex-shrink: 0;
}

.admin-dropdown-menu .dropdown-divider {
    margin: 6px 0;
}

.admin-theme-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.45rem;
    height: 2.45rem;
    flex: 0 0 2.45rem;
    padding: 0;
    border: 1px solid var(--border-color);
    border-radius: 50%;
    background: #fff;
    color: var(--primary-dark);
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
}

.admin-theme-toggle:hover {
    background: #eef3ff;
    border-color: #b8caff;
}

.admin-theme-toggle i {
    font-size: 1.1rem;
}

.admin-site.dark-theme {
    color-scheme: dark;
    --sidebar-bg: #111827;
    --content-bg: #0b1220;
    --border-color: #293548;
    background: var(--content-bg);
    color: #e5e7eb;
}

.admin-site.dark-theme .card,
.admin-site.dark-theme .modal-content,
.admin-site.dark-theme .dropdown-menu,
.admin-site.dark-theme .list-group-item,
.admin-site.dark-theme .accordion-item {
    background-color: #111827;
    color: #e5e7eb;
    border-color: var(--border-color);
}

.admin-site.dark-theme .sidebar-brand,
.admin-site.dark-theme .sidebar-footer,
.admin-site.dark-theme .topbar,
.admin-site.dark-theme .card-header,
.admin-site.dark-theme .card-footer,
.admin-site.dark-theme .modal-header,
.admin-site.dark-theme .modal-footer,
.admin-site.dark-theme .dropdown-divider,
.admin-site.dark-theme .accordion-button {
    border-color: var(--border-color);
}

.admin-site.dark-theme .sidebar-footer {
    background: #0f1724;
}

.admin-site.dark-theme .sidebar-menu a {
    color: #cbd5e1;
}

.admin-site.dark-theme .sidebar-menu a.active,
.admin-site.dark-theme .sidebar-menu a.active:hover {
    background: #078f83;
    color: #fff;
}

.admin-site.dark-theme .sidebar-menu a:not(.active):hover,
.admin-site.dark-theme .admin-profile-button:hover,
.admin-site.dark-theme .dropdown-item:hover,
.admin-site.dark-theme .dropdown-item:focus {
    background-color: #1e293b;
    color: #f8fafc;
}

.admin-site.dark-theme .menu-label,
.admin-site.dark-theme .topbar-title small,
.admin-site.dark-theme .text-muted,
.admin-site.dark-theme .admin-profile-chevron {
    color: #94a3b8 !important;
}

.admin-site.dark-theme .admin-theme-toggle {
    background: #1e293b;
    border-color: #334155;
    color: #fbbf24;
}

.admin-site.dark-theme .admin-theme-toggle:hover {
    background: #293548;
}

.admin-site.dark-theme .admin-notification {
    background: #1e293b;
    color: #bfdbfe;
}

.admin-site.dark-theme .admin-dropdown-avatar {
    background: #1e3a5f;
    color: #bfdbfe;
}

.admin-site.dark-theme .admin-dropdown-menu {
    border-color: var(--border-color);
}

.admin-site.dark-theme .dropdown-header,
.admin-site.dark-theme .dropdown-item,
.admin-site.dark-theme .dropdown-item-text {
    color: #e5e7eb;
}

.admin-site.dark-theme .dropdown-item.text-danger {
    color: #f87171 !important;
}

.admin-site.dark-theme .dropdown-item.text-danger:hover {
    background: #3b2027;
}

.admin-site.dark-theme .content .table {
    --bs-table-color: #e5e7eb;
    --bs-table-bg: #111827;
    --bs-table-border-color: var(--border-color);
    --bs-table-striped-bg: #172235;
    --bs-table-striped-color: #e5e7eb;
    --bs-table-hover-bg: #1e293b;
    --bs-table-hover-color: #f8fafc;
}

.admin-site.dark-theme .content .table > :not(caption) > * > * {
    color: inherit;
    border-color: var(--border-color);
}

.admin-site.dark-theme .content .table thead,
.admin-site.dark-theme .content .table-light,
.admin-site.dark-theme .content .table-light > * > * {
    --bs-table-color: #e5e7eb;
    --bs-table-bg: #1e293b;
    color: #e5e7eb;
    background-color: #1e293b;
}

.admin-site.dark-theme .content .table .table-warning {
    --bs-table-bg: rgba(245, 158, 11, 0.16);
    --bs-table-color: #fde68a;
}

.admin-site.dark-theme .form-control,
.admin-site.dark-theme .form-select,
.admin-site.dark-theme .input-group-text {
    color: #e5e7eb;
    background-color: #0f1724;
    border-color: #334155;
}

.admin-site.dark-theme .form-control::placeholder {
    color: #94a3b8;
}

.admin-site.dark-theme .form-control:focus,
.admin-site.dark-theme .form-select:focus {
    color: #f8fafc;
    background-color: #0f1724;
    border-color: #60a5fa;
}

.admin-site.dark-theme .form-control:disabled,
.admin-site.dark-theme .form-select:disabled {
    color: #94a3b8;
    background-color: #1e293b;
}

.admin-site.dark-theme .bg-white,
.admin-site.dark-theme .bg-light,
.admin-site.dark-theme .bg-light-subtle,
.admin-site.dark-theme .accordion-button,
.admin-site.dark-theme .page-link {
    color: #e5e7eb !important;
    background-color: #111827 !important;
    border-color: var(--border-color);
}

.admin-site.dark-theme .form-text {
    color: #94a3b8;
}

.admin-site.dark-theme .border-top,
.admin-site.dark-theme .border-bottom {
    border-color: var(--border-color) !important;
}

.admin-site.dark-theme .text-dark:not(.badge) {
    color: #e5e7eb !important;
}

.admin-site.dark-theme .badge.bg-warning.text-dark {
    color: #111827 !important;
}

.admin-site.dark-theme .btn-light,
.admin-site.dark-theme .btn-outline-secondary {
    color: #e5e7eb;
    background-color: #1e293b;
    border-color: #475569;
}

.admin-site.dark-theme .btn-light:hover,
.admin-site.dark-theme .btn-outline-secondary:hover {
    color: #fff;
    background-color: #334155;
    border-color: #64748b;
}

.admin-site.dark-theme .pagination {
    --bs-pagination-color: #cbd5e1;
    --bs-pagination-bg: #111827;
    --bs-pagination-border-color: var(--border-color);
    --bs-pagination-hover-color: #fff;
    --bs-pagination-hover-bg: #1e293b;
    --bs-pagination-hover-border-color: #475569;
    --bs-pagination-disabled-bg: #0f1724;
    --bs-pagination-disabled-border-color: var(--border-color);
}

.admin-site.dark-theme .alert-light,
.admin-site.dark-theme .alert-secondary {
    color: #e5e7eb;
    background-color: #1e293b;
    border-color: #334155;
}

.admin-site.dark-theme .modal-backdrop {
    --bs-backdrop-bg: #020617;
}

.admin-site.dark-theme .btn-close {
    filter: invert(1) grayscale(100%) brightness(200%);
}

.admin-site.dark-theme hr {
    border-color: var(--border-color);
    opacity: 1;
}


/* ==========================================================
   MOBILE
========================================================== */

@media (max-width: 576px) {

    .admin-profile-info {
        display: none;
    }

    .admin-profile-button {
        gap: 6px;
    }

    .admin-dropdown-menu {
        min-width: 250px;
    }

}

@media (prefers-reduced-motion: reduce) {
    .topbar-greeting-word,
    .topbar-greeting-word--exit {
        animation-duration: 0.01ms;
        animation-delay: 0ms;
    }
}

.sidebar-menu a:focus-visible,
.sidebar-toggle:focus-visible,
.mobile-sidebar-toggle:focus-visible,
.admin-theme-toggle:focus-visible,
.admin-notification:focus-visible,
.admin-profile-button:focus-visible,
.content .btn:focus-visible,
.content .form-control:focus-visible,
.content .form-select:focus-visible,
.dropdown-item:focus-visible {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

.admin-site.dark-theme .sidebar-menu a:focus-visible,
.admin-site.dark-theme .sidebar-toggle:focus-visible,
.admin-site.dark-theme .mobile-sidebar-toggle:focus-visible,
.admin-site.dark-theme .admin-theme-toggle:focus-visible,
.admin-site.dark-theme .admin-notification:focus-visible,
.admin-site.dark-theme .admin-profile-button:focus-visible,
.admin-site.dark-theme .content .btn:focus-visible,
.admin-site.dark-theme .content .form-control:focus-visible,
.admin-site.dark-theme .content .form-select:focus-visible,
.admin-site.dark-theme .dropdown-item:focus-visible {
    outline-color: #60a5fa;
}

    </style>

    @stack('styles')

</head>


@php
    $sidebarRoleLabel = match (auth()->user()->role) {
        'admin' => 'Administrator',
        'operator' => 'Operator',
        'pimpinan' => 'Pimpinan',
        default => 'Petugas',
    };
    $sidebarInitial = strtoupper(substr(auth()->user()->name ?? 'A', 0, 1));
    $greetingPeriod = now()->hour < 11 ? 'pagi' : (now()->hour < 15 ? 'siang' : (now()->hour < 18 ? 'sore' : 'malam'));
    $greetingInitial = 'Selamat ' . $greetingPeriod . ', ' . (auth()->user()->name ?? '');
    $greetingWords = preg_split('/\s+/', trim($greetingInitial)) ?: [];
@endphp

<body class="admin-site {{ request()->routeIs('admin.laporan.*') ? 'report-page' : '' }} {{ request()->routeIs('admin.dashboard') ? 'dashboard-page' : '' }}">


{{-- ==========================================================
SIDEBAR
========================================================== --}}

<button
    type="button"
    class="sidebar-overlay"
    aria-label="Tutup menu navigasi"
    aria-hidden="true"
></button>

<aside class="sidebar" id="admin-sidebar">

{{-- BRAND --}}
<div class="sidebar-brand">

    <div class="brand-icon">
        <img
            src="{{ asset('images/logo-sapa-jukir.png') }}" alt="Logo SAPA JUKIR"
    >    
    </div>

    <div class="brand-text">
        <h5>SAPA JUKIR</h5>

    </div>

    <button
        type="button"
        class="sidebar-toggle"
        aria-label="Lipat sidebar"
        aria-expanded="true"
    >
        <i class="bi bi-chevron-left" aria-hidden="true"></i>
    </button>

</div>

<div class="sidebar-user-card">
    <div class="sidebar-user-avatar" aria-hidden="true">{{ $sidebarInitial }}</div>
    <div class="sidebar-user-copy">
        <span class="sidebar-user-name">{{ auth()->user()->name ?? 'Pengguna' }}</span>
    </div>
</div>

{{-- MENU --}}
<nav class="sidebar-menu">

    {{-- ==================================================
        MENU UTAMA
    =================================================== --}}

    <div class="menu-label">
        Menu Utama
    </div>


    {{-- DASHBOARD --}}

    <a
        href="{{ route('admin.dashboard') }}"
        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif
    >

        <i class="bi bi-grid"></i>

        <span>
            Dashboard
        </span>

    </a>


    @if(in_array(auth()->user()->role, ['admin', 'pimpinan'], true))
        <div class="menu-label">Data Master</div>
        <a href="{{ route('admin.jukir.index') }}" class="{{ request()->routeIs('admin.jukir.*') ? 'active' : '' }}" @if(request()->routeIs('admin.jukir.*')) aria-current="page" @endif><i class="bi bi-person-badge"></i><span>Data Petugas</span></a>
        <a href="{{ route('admin.sumber-pemasukan.index') }}" class="{{ request()->routeIs('admin.sumber-pemasukan.*') ? 'active' : '' }}" @if(request()->routeIs('admin.sumber-pemasukan.*')) aria-current="page" @endif><i class="bi bi-p-square"></i><span>Jenis Sumber Pendapatan</span></a>
        <a href="{{ route('admin.titik-parkir.index') }}" class="{{ request()->routeIs('admin.titik-parkir.*') ? 'active' : '' }}" @if(request()->routeIs('admin.titik-parkir.*')) aria-current="page" @endif><i class="bi bi-geo-alt"></i><span>Objek Pendapatan</span></a>
        <a href="{{ route('admin.tarif.index') }}" class="{{ request()->routeIs('admin.tarif.*') ? 'active' : '' }}" @if(request()->routeIs('admin.tarif.*')) aria-current="page" @endif><i class="bi bi-cash-stack"></i><span>Tarif Retribusi</span></a>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.karcis.index') }}" class="{{ request()->routeIs('admin.karcis.*') ? 'active' : '' }}" @if(request()->routeIs('admin.karcis.*')) aria-current="page" @endif><i class="bi bi-ticket-perforated"></i><span>Penyerahan Karcis</span></a>
        @endif
    @endif

    @if(in_array(auth()->user()->role, ['admin', 'operator', 'pimpinan'], true))
        <div class="menu-label">Operasional</div>
        <a href="{{ route('admin.penempatan-jukir.index') }}" class="{{ request()->routeIs('admin.penempatan-jukir.*') ? 'active' : '' }}" @if(request()->routeIs('admin.penempatan-jukir.*')) aria-current="page" @endif><i class="bi bi-geo"></i><span>Penempatan Petugas</span></a>
        <a href="{{ route('admin.setoran.index') }}" class="{{ request()->routeIs('admin.setoran.*') ? 'active' : '' }}" @if(request()->routeIs('admin.setoran.*')) aria-current="page" @endif><i class="bi bi-cash-coin"></i><span>Setoran</span></a>
        @if(in_array(auth()->user()->role, ['admin', 'pimpinan'], true))
            <a href="{{ route('admin.target-pendapatan.index') }}" class="{{ request()->routeIs('admin.target-pendapatan.*') ? 'active' : '' }}" @if(request()->routeIs('admin.target-pendapatan.*')) aria-current="page" @endif><i class="bi bi-bullseye"></i><span>Target Pendapatan</span></a>
        @endif
    @endif

    @if(in_array(auth()->user()->role, ['admin', 'pimpinan'], true))
        <div class="menu-label">Laporan</div>
        <a href="{{ route('admin.capaian-bulanan.index') }}" class="{{ request()->routeIs('admin.capaian-bulanan.*') ? 'active' : '' }}" @if(request()->routeIs('admin.capaian-bulanan.*')) aria-current="page" @endif><i class="bi bi-file-earmark-text"></i><span>Capaian Bulanan</span></a>
        <a href="{{ route('admin.laporan.capaian-realisasi') }}" class="{{ request()->routeIs('admin.laporan.capaian-realisasi*') ? 'active' : '' }}" @if(request()->routeIs('admin.laporan.capaian-realisasi*')) aria-current="page" @endif><i class="bi bi-graph-up-arrow"></i><span>Laporan Capaian Realisasi</span></a>
        <a href="{{ route('admin.laporan.setoran') }}" class="{{ request()->routeIs('admin.laporan.setoran*') ? 'active' : '' }}" @if(request()->routeIs('admin.laporan.setoran*')) aria-current="page" @endif><i class="bi bi-cash-coin"></i><span>Laporan Setoran</span></a>
        <a href="{{ route('admin.pengaduan.index') }}" class="{{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}" @if(request()->routeIs('admin.pengaduan.*')) aria-current="page" @endif><i class="bi bi-chat-left-text"></i><span>Aduan</span></a>
    @endif

    @if(in_array(auth()->user()->role, ['admin', 'pimpinan'], true))
        <div class="menu-label">Pengaturan</div>
        <a href="{{ route('admin.site-settings.index') }}" class="{{ request()->routeIs('admin.site-settings.*') ? 'active' : '' }}" @if(request()->routeIs('admin.site-settings.*')) aria-current="page" @endif><i class="bi bi-gear-wide-connected"></i><span>SEO &amp; Publik</span></a>
        <a href="{{ route('admin.sambutan.index') }}" class="{{ request()->routeIs('admin.sambutan.*') ? 'active' : '' }}" @if(request()->routeIs('admin.sambutan.*')) aria-current="page" @endif><i class="bi bi-person-video3"></i><span>Sambutan Publik</span></a>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.gallery.index') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}" @if(request()->routeIs('admin.gallery.*')) aria-current="page" @endif><i class="bi bi-images"></i><span>Galeri Publik</span></a>
            <a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}" @if(request()->routeIs('admin.news.*')) aria-current="page" @endif><i class="bi bi-newspaper"></i><span>Pengaturan Berita</span></a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" @if(request()->routeIs('admin.users.*')) aria-current="page" @endif><i class="bi bi-people"></i><span>Manajemen Pengguna</span></a>
        @endif
    @endif

</nav>

<div class="sidebar-footer">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="sidebar-logout">
            <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
            <span>Logout</span>
        </button>
    </form>
</div>

</aside>



{{-- ==========================================================
    MAIN
========================================================== --}}

<div class="main">


    {{-- ======================================================
    TOPBAR
====================================================== --}}

<header class="topbar">

    <div class="topbar-glass">

    <button
        type="button"
        class="mobile-sidebar-toggle"
        aria-label="Buka menu navigasi"
        aria-controls="admin-sidebar"
        aria-expanded="false"
    >
        <i class="bi bi-list" aria-hidden="true"></i>
    </button>

    <div
        class="topbar-greeting"
        id="admin-greeting-line"
        data-greeting-initial="{{ $greetingInitial }}"
        aria-label="{{ $greetingInitial }}"
    >
        @foreach ($greetingWords as $wordIndex => $word)
            <span class="topbar-greeting-word" style="--word-index: {{ $wordIndex }}" aria-hidden="true">{{ $word }}</span>
        @endforeach
    </div>

    {{-- ==================================================
        ADMIN PROFILE DROPDOWN
    =================================================== --}}

    <div class="topbar-actions">

    <button
        type="button"
        class="admin-theme-toggle"
        aria-label="Ubah ke mode gelap"
        aria-pressed="false"
        title="Ubah ke mode gelap"
    >
        <i class="bi bi-sun-fill" aria-hidden="true"></i>
    </button>

    @if(auth()->user()->role === 'admin')
        <div class="dropdown">

            @php($unreadPengaduans = \App\Models\Pengaduan::whereNull('dibaca_at')->latest()->take(5)->get())

            <button
                type="button"
                class="admin-notification"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                aria-label="Notifikasi aduan"
            >
                <i class="bi bi-bell fs-5"></i>
                @if($unreadPengaduans->count())
                    <span class="badge rounded-pill text-bg-danger">{{ $unreadPengaduans->count() }}</span>
                @endif
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width: 320px;">
                <li><h6 class="dropdown-header">Aduan Baru</h6></li>
                @forelse($unreadPengaduans as $pengaduan)
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('admin.pengaduan.show', $pengaduan) }}">
                            <strong class="d-block">{{ $pengaduan->nama }}</strong>
                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($pengaduan->detail, 48) }}</small>
                        </a>
                    </li>
                @empty
                    <li><span class="dropdown-item-text text-muted">Tidak ada aduan baru.</span></li>
                @endforelse
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center" href="{{ route('admin.pengaduan.index') }}">Lihat semua aduan</a></li>
            </ul>
        </div>
    @endif

    <div class="dropdown admin-profile">

        <button
            type="button"
            class="admin-profile-button"
            data-bs-toggle="dropdown"
            data-bs-auto-close="true"
            aria-expanded="false"
        >

            {{-- INFORMASI ADMIN --}}

            <div class="admin-profile-info">

                <div class="fw-semibold">
                    {{ auth()->user()->name ?? ($sidebarRoleLabel === 'Pimpinan' ? 'Pimpinan' : 'Administrator') }}
                </div>

            </div>


            {{-- AVATAR --}}

            <div class="profile-avatar">

                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}

            </div>


            {{-- ICON DROPDOWN --}}

            <i class="bi bi-chevron-down admin-profile-chevron"></i>

        </button>


        {{-- ==================================================
            DROPDOWN MENU
        =================================================== --}}

        <ul class="dropdown-menu dropdown-menu-end admin-dropdown-menu">

            {{-- INFORMASI AKUN --}}

            <li>

                <div class="admin-dropdown-header">

                    <div class="admin-dropdown-avatar">

                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}

                    </div>

                    <div>

                        <div class="fw-semibold">

                            {{ auth()->user()->name ?? ($sidebarRoleLabel === 'Pimpinan' ? 'Pimpinan' : 'Administrator') }}

                        </div>

                        <small class="text-muted">

                            {{ auth()->user()->username ?? '' }}

                        </small>

                    </div>

                </div>

            </li>


            <li>

                <hr class="dropdown-divider">

            </li>


            {{-- LOGOUT --}}

            <li>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="dropdown-item text-danger admin-logout-button"
                    >

                        <i class="bi bi-box-arrow-right me-2" aria-hidden="true"></i>

                        Logout

                    </button>

                </form>

            </li>

        </ul>

    </div>

    </div>

    </div>

</header>

    {{-- ======================================================
        CONTENT
    ======================================================= --}}

    <main class="content">


        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div
                class="alert alert-success alert-dismissible fade show auto-dismiss-alert global-alert"
                role="alert"
            >

                <i class="bi bi-check-circle me-2"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup notifikasi"
                ></button>

            </div>

        @endif

        @if(session('error'))

            <div
                class="alert alert-danger alert-dismissible fade show global-alert"
                role="alert"
            >

                <i class="bi bi-exclamation-circle me-2"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup notifikasi"
                ></button>

            </div>

        @endif


        {{-- ERROR MESSAGE --}}

        @if($errors->any())

            <div class="alert alert-danger alert-dismissible fade show global-alert" role="alert">

                <div class="fw-semibold mb-2">

                    <i class="bi bi-exclamation-triangle me-2"></i>

                    Terjadi kesalahan:

                </div>


                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup notifikasi"
                ></button>

            </div>

        @endif


        @yield('content')

    </main>

</div>


{{-- ==========================================================
    BOOTSTRAP JS
========================================================== --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


{{-- ==========================================================
    AUTO HIDE SUCCESS MESSAGE
========================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {
    const collapseToggle = document.querySelector('.sidebar-toggle');
    const mobileToggle = document.querySelector('.mobile-sidebar-toggle');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    const sidebar = document.querySelector('.sidebar');

    collapseToggle?.addEventListener('click', function () {
        const collapsed = document.body.classList.toggle('sidebar-collapsed');

        collapseToggle.setAttribute('aria-expanded', String(!collapsed));
        collapseToggle.setAttribute('aria-label', collapsed ? 'Buka sidebar' : 'Lipat sidebar');
    });

    const setMobileSidebarOpen = function (isOpen) {
        document.body.classList.toggle('sidebar-open', isOpen);
        mobileToggle?.setAttribute('aria-expanded', String(isOpen));
        mobileToggle?.setAttribute('aria-label', isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
        sidebarOverlay?.setAttribute('aria-hidden', String(!isOpen));
    };

    mobileToggle?.addEventListener('click', function () {
        setMobileSidebarOpen(!document.body.classList.contains('sidebar-open'));
    });

    sidebarOverlay?.addEventListener('click', function () {
        setMobileSidebarOpen(false);
    });

    sidebar?.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            setMobileSidebarOpen(false);
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            setMobileSidebarOpen(false);
        }
    });

    window.matchMedia('(min-width: 992px)').addEventListener('change', function (event) {
        if (event.matches) {
            setMobileSidebarOpen(false);
        }
    });

});

document.addEventListener('DOMContentLoaded', function () {
    const greetingLine = document.getElementById('admin-greeting-line');
    if (!greetingLine) {
        return;
    }

    const greetingMessages = [
        greetingLine.dataset.greetingInitial,
        'Selamat Datang di SAPA JUKIR',
        'Sistem Administrasi Pelayanan dan Aduan Juru Parkir',
        'Dinas Perhubungan Kabupaten Sinjai',
    ].filter(Boolean);
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const wordDelay = prefersReducedMotion ? 0 : 180;
    const wordDuration = prefersReducedMotion ? 0 : 550;
    const readingPause = 2400;
    let greetingIndex = 0;

    const showGreeting = function (message) {
        const words = message.split(/\s+/);
        greetingLine.setAttribute('aria-label', message);
        greetingLine.replaceChildren(...words.map(function (word, index) {
            const wordElement = document.createElement('span');
            wordElement.className = 'topbar-greeting-word';
            wordElement.style.setProperty('--word-index', String(index));
            wordElement.setAttribute('aria-hidden', 'true');
            wordElement.textContent = word;
            return wordElement;
        }));

        const revealDuration = prefersReducedMotion ? 0 : (words.length - 1) * wordDelay + wordDuration;
        window.setTimeout(rotateGreeting, revealDuration + readingPause);
    };

    const rotateGreeting = function () {
        const currentWords = Array.from(greetingLine.querySelectorAll('.topbar-greeting-word'));
        if (prefersReducedMotion) {
            greetingIndex = (greetingIndex + 1) % greetingMessages.length;
            showGreeting(greetingMessages[greetingIndex]);
            return;
        }

        currentWords.forEach(function (word, index) {
            word.style.setProperty('--word-index', String(index));
            word.classList.add('topbar-greeting-word--exit');
        });

        window.setTimeout(function () {
            greetingIndex = (greetingIndex + 1) % greetingMessages.length;
            showGreeting(greetingMessages[greetingIndex]);
        }, 350);
    };

    const initialRevealDuration = prefersReducedMotion
        ? 0
        : (greetingMessages[0].split(/\s+/).length - 1) * wordDelay + wordDuration;
    window.setTimeout(rotateGreeting, initialRevealDuration + readingPause);
});

document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.querySelector('.admin-theme-toggle');
    const storedTheme = localStorage.getItem('public-theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const applyTheme = function (darkMode) {
        document.documentElement.classList.toggle('dark-theme', darkMode);
        document.body.classList.toggle('dark-theme', darkMode);

        if (themeToggle) {
            const icon = themeToggle.querySelector('i');
            themeToggle.setAttribute('aria-pressed', String(darkMode));
            themeToggle.setAttribute('aria-label', darkMode ? 'Ubah ke mode terang' : 'Ubah ke mode gelap');
            themeToggle.title = darkMode ? 'Ubah ke mode terang' : 'Ubah ke mode gelap';

            if (icon) {
                icon.className = darkMode ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
            }
        }
    };

    applyTheme(storedTheme ? storedTheme === 'dark' : prefersDark);

    themeToggle?.addEventListener('click', function () {
        const darkMode = !document.body.classList.contains('dark-theme');
        localStorage.setItem('public-theme', darkMode ? 'dark' : 'light');
        applyTheme(darkMode);
    });
});

document.addEventListener('DOMContentLoaded', function () {

    const alerts = document.querySelectorAll('.auto-dismiss-alert');

    alerts.forEach(function (alert) {
        window.setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) {
                bsAlert.close();
            } else {
                alert.classList.add('fade');
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-6px)';
                window.setTimeout(function () {
                    alert.remove();
                }, 300);
            }
        }, 4000);
    });

});

document.addEventListener('DOMContentLoaded', function () {
    const globalMessages = new Set(
        Array.from(document.querySelectorAll('.global-alert'))
            .map((alert) => alert.textContent.replace(/\s+/g, ' ').trim())
    );

    document.querySelectorAll('.content > .alert:not(.global-alert)').forEach((alert) => {
        const message = alert.textContent.replace(/\s+/g, ' ').trim();
        if (globalMessages.has(message)) {
            alert.remove();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('submit', function (event) {
        if (event.defaultPrevented) {
            return;
        }

        const form = event.target;
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        const method = (form.getAttribute('method') || 'get').toLowerCase();
        if (method === 'get' || form.target === '_blank' || form.hasAttribute('data-no-disable')) {
            return;
        }

        if (form.dataset.submitting === 'true') {
            event.preventDefault();
            return;
        }

        form.dataset.submitting = 'true';

        const submitButtons = form.querySelectorAll('button[type="submit"], button:not([type]), input[type="submit"]');
        const activeSubmitter = event.submitter || submitButtons[0] || null;

        if (activeSubmitter && activeSubmitter.name) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = activeSubmitter.name;
            hiddenInput.value = activeSubmitter.value || '';
            form.appendChild(hiddenInput);
        }

        submitButtons.forEach((button) => {
            button.disabled = true;
        });

        if (activeSubmitter) {
            if (activeSubmitter.tagName === 'BUTTON') {
                activeSubmitter.innerHTML = '<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Memproses...';
            } else if (activeSubmitter.tagName === 'INPUT') {
                activeSubmitter.value = 'Memproses...';
            }
        }
    });
});

</script>


@stack('scripts')

</body>

</html>