<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide:wght@400&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php // Explicit title guard to avoid showing 404 on the home page title bar ?>
    <title><?php echo is_front_page() ? get_bloginfo('name') . ' – ' . get_bloginfo('description') : wp_get_document_title(); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site-container">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="sidebar-logo">
                <i class="fas fa-graduation-cap"></i> Cashvers Academy
            </a>
            <p class="sidebar-tagline">Learn, Earn, Grow</p>
        </div>
        
        <div class="sidebar-search">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <i class="fas fa-search"></i>
                <input type="search" placeholder="Search articles..." value="<?php echo get_search_query(); ?>" name="s" />
            </form>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-item <?php echo is_home() ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="<?php echo esc_url(get_category_link(get_cat_ID('Crypto'))); ?>" class="nav-item">
                <i class="fas fa-coins"></i> Crypto
            </a>
            <a href="<?php echo esc_url(get_category_link(get_cat_ID('Gaming'))); ?>" class="nav-item">
                <i class="fas fa-gamepad"></i> Gaming
            </a>
            <a href="<?php echo esc_url(get_category_link(get_cat_ID('Apps'))); ?>" class="nav-item">
                <i class="fas fa-mobile-alt"></i> Apps
            </a>
            <a href="<?php echo esc_url(get_category_link(get_cat_ID('Tips & Tricks'))); ?>" class="nav-item">
                <i class="fas fa-lightbulb"></i> Tips & Tricks
            </a>
            <a href="<?php echo esc_url(get_category_link(get_cat_ID('Earn Money'))); ?>" class="nav-item">
                <i class="fas fa-dollar-sign"></i> Earn Money
            </a>
            <a href="https://cashvers.com" class="nav-item" target="_blank">
                <i class="fas fa-external-link-alt"></i> Main Website
            </a>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Header -->
        <header class="site-header">
            <div class="header-content">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
                    <i class="fas fa-graduation-cap"></i> <?php bloginfo('name'); ?>
                </a>
                
                <div class="header-search">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <i class="fas fa-search"></i>
                        <input type="search" placeholder="Search articles..." value="<?php echo get_search_query(); ?>" name="s" />
                    </form>
                </div>
                
                <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">