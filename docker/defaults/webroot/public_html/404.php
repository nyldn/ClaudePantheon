<?php http_response_code(404); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - ClaudePantheon</title>
    <style>
        :root {
            --ctp-rosewater: #f5e0dc;
            --ctp-flamingo: #f2cdcd;
            --ctp-pink: #f5c2e7;
            --ctp-mauve: #cba6f7;
            --ctp-red: #f38ba8;
            --ctp-maroon: #eba0ac;
            --ctp-peach: #fab387;
            --ctp-yellow: #f9e2af;
            --ctp-green: #a6e3a1;
            --ctp-teal: #94e2d5;
            --ctp-sky: #89dceb;
            --ctp-sapphire: #74c7ec;
            --ctp-blue: #89b4fa;
            --ctp-lavender: #b4befe;
            --ctp-text: #cdd6f4;
            --ctp-subtext1: #bac2de;
            --ctp-subtext0: #a6adc8;
            --ctp-overlay2: #9399b2;
            --ctp-overlay1: #7f849c;
            --ctp-overlay0: #6c7086;
            --ctp-surface2: #585b70;
            --ctp-surface1: #45475a;
            --ctp-surface0: #313244;
            --ctp-base: #1e1e2e;
            --ctp-mantle: #181825;
            --ctp-crust: #11111b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, var(--ctp-crust) 0%, var(--ctp-base) 50%, var(--ctp-mantle) 100%);
            color: var(--ctp-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem;
        }

        .header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .logo {
            font-size: 4rem;
            margin-bottom: 0.75rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--ctp-mauve);
            margin-bottom: 0.25rem;
            letter-spacing: 0.05em;
        }

        .title a {
            color: var(--ctp-mauve);
            text-decoration: none;
        }

        .title a:hover {
            text-decoration: underline;
            color: var(--ctp-lavender);
        }

        .blurb {
            font-size: 0.95rem;
            color: var(--ctp-subtext0);
            max-width: 500px;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .blurb a {
            color: var(--ctp-sapphire);
            text-decoration: none;
        }

        .blurb a:hover {
            text-decoration: underline;
            color: var(--ctp-blue);
        }

        .error-code {
            font-size: 5rem;
            font-weight: 800;
            color: var(--ctp-surface2);
            letter-spacing: 0.1em;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .error-message {
            font-size: 1.2rem;
            color: var(--ctp-subtext0);
            margin-bottom: 1.5rem;
        }

        .requested-path {
            font-family: 'SF Mono', 'Fira Code', 'Cascadia Code', monospace;
            background: var(--ctp-surface0);
            color: var(--ctp-peach);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--ctp-surface2);
            font-size: 0.9rem;
            margin-bottom: 2.5rem;
            max-width: 500px;
            overflow-x: auto;
            white-space: nowrap;
        }

        /* Sections */
        .sections {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            max-width: 960px;
            width: 100%;
            margin-bottom: 2rem;
        }

        .card {
            background: var(--ctp-surface0);
            border: 1px solid var(--ctp-surface2);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--ctp-mauve);
        }

        .card-header-icon {
            font-size: 1.25rem;
        }

        .route-list {
            list-style: none;
        }

        .route-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--ctp-surface1);
            font-size: 0.9rem;
        }

        .route-list li:last-child {
            border-bottom: none;
        }

        .route-path {
            font-family: 'SF Mono', 'Fira Code', 'Cascadia Code', monospace;
            color: var(--ctp-sapphire);
            font-size: 0.85rem;
            min-width: 110px;
        }

        .route-path a {
            color: var(--ctp-sapphire);
            text-decoration: none;
        }

        .route-path a:hover {
            text-decoration: underline;
            color: var(--ctp-blue);
        }

        .route-desc {
            color: var(--ctp-subtext0);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            border-bottom: 1px solid var(--ctp-surface1);
            font-size: 0.9rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--ctp-subtext0);
        }

        .info-value {
            color: var(--ctp-text);
            font-family: 'SF Mono', 'Fira Code', 'Cascadia Code', monospace;
            font-size: 0.85rem;
        }

        .info-value.active {
            color: var(--ctp-green);
        }

        .info-value.inactive {
            color: var(--ctp-overlay0);
        }

        /* Shell commands */
        .shell-list {
            list-style: none;
        }

        .shell-list li {
            display: flex;
            align-items: baseline;
            gap: 0.75rem;
            padding: 0.35rem 0;
            font-size: 0.85rem;
        }

        .shell-cmd {
            font-family: 'SF Mono', 'Fira Code', 'Cascadia Code', monospace;
            color: var(--ctp-green);
            min-width: 90px;
        }

        .shell-desc {
            color: var(--ctp-subtext0);
        }

        /* Home button */
        .home-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--ctp-surface0);
            color: var(--ctp-mauve);
            border: 2px solid var(--ctp-mauve);
            border-radius: 12px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .home-btn:hover {
            background: var(--ctp-mauve);
            color: var(--ctp-crust);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }

        .home-btn:focus-visible {
            outline: 2px solid var(--ctp-lavender);
            outline-offset: 3px;
        }

        .footer {
            margin-top: auto;
            text-align: center;
            padding-top: 2rem;
        }

        .footer-text {
            color: var(--ctp-overlay1);
            font-size: 0.9rem;
        }

        .footer-text a {
            color: var(--ctp-sapphire);
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
            color: var(--ctp-blue);
        }

        .footer-credit {
            color: var(--ctp-overlay1);
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        @media (prefers-reduced-motion: reduce) {
            .logo { animation: none; }
            .home-btn { transition: none; }
        }

        @media (max-width: 900px) {
            .sections { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 600px) {
            .logo { font-size: 3rem; }
            .title { font-size: 1.5rem; }
            .error-code { font-size: 3.5rem; }
            .sections { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo" aria-hidden="true">&#x1f3db;&#xfe0f;</div>
        <h1 class="title"><a href="/">ClaudePantheon</a></h1>
        <p class="blurb">A persistent, Docker-based Claude Code environment you can access from any device with a web browser. Terminal, file browser, WebDAV, and MCP integrations &mdash; all behind a single port.</p>
        <div class="error-code" aria-hidden="true">404</div>
        <p class="error-message">This path doesn't lead anywhere in the Pantheon.</p>
    </header>

    <div class="requested-path"><?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/unknown'); ?></div>

    <div class="sections">

        <!-- Available Routes -->
        <div class="card">
            <div class="card-header">
                <span class="card-header-icon" aria-hidden="true">&#x1f5fa;&#xfe0f;</span>
                <span>Available Routes</span>
            </div>
            <ul class="route-list">
                <li>
                    <span class="route-path"><a href="/">/</a></span>
                    <span class="route-desc">Landing page</span>
                </li>
                <li>
                    <span class="route-path"><a href="/terminal/">/terminal/</a></span>
                    <span class="route-desc">Web terminal (Claude Code)</span>
                </li>
                <li>
                    <span class="route-path"><a href="/files/">/files/</a></span>
                    <span class="route-desc">File browser</span>
                </li>
                <?php if (getenv('ENABLE_WEBDAV') === 'true'): ?>
                <li>
                    <span class="route-path"><a href="/webdav/">/webdav/</a></span>
                    <span class="route-desc">WebDAV access</span>
                </li>
                <?php endif; ?>
                <li>
                    <span class="route-path"><a href="/health">/health</a></span>
                    <span class="route-desc">Health check</span>
                </li>
            </ul>
        </div>

        <!-- Connection Details -->
        <div class="card">
            <div class="card-header">
                <span class="card-header-icon" aria-hidden="true">&#x1f310;</span>
                <span>Connection Details</span>
            </div>
            <div class="info-row">
                <span class="info-label">Host</span>
                <span class="info-value"><?php echo htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'localhost'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Port</span>
                <span class="info-value"><?php echo htmlspecialchars($_SERVER['SERVER_PORT'] ?? '7681'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Protocol</span>
                <span class="info-value"><?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'HTTPS' : 'HTTP'; ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Your IP</span>
                <span class="info-value"><?php echo htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'unknown'); ?></span>
            </div>
            <?php if (getenv('ENABLE_SSH') === 'true'): ?>
            <div class="info-row">
                <span class="info-label">SSH</span>
                <span class="info-value active"><?php
                    $host = explode(':', $_SERVER['HTTP_HOST'] ?? 'localhost')[0];
                    echo htmlspecialchars("ssh claude@{$host} -p 2222");
                ?></span>
            </div>
            <?php endif; ?>
            <div class="info-row">
                <span class="info-label">FileBrowser</span>
                <span class="info-value <?php echo getenv('ENABLE_FILEBROWSER') !== 'false' ? 'active' : 'inactive'; ?>">
                    <?php echo getenv('ENABLE_FILEBROWSER') !== 'false' ? 'enabled' : 'disabled'; ?>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">WebDAV</span>
                <span class="info-value <?php echo getenv('ENABLE_WEBDAV') === 'true' ? 'active' : 'inactive'; ?>">
                    <?php echo getenv('ENABLE_WEBDAV') === 'true' ? 'enabled' : 'disabled'; ?>
                </span>
            </div>
        </div>

        <!-- Quick Start -->
        <div class="card">
            <div class="card-header">
                <span class="card-header-icon" aria-hidden="true">&#x26a1;</span>
                <span>Quick Start (Terminal)</span>
            </div>
            <ul class="shell-list">
                <li>
                    <span class="shell-cmd">cc-new</span>
                    <span class="shell-desc">Start new Claude session</span>
                </li>
                <li>
                    <span class="shell-cmd">cc</span>
                    <span class="shell-desc">Continue last session</span>
                </li>
                <li>
                    <span class="shell-cmd">cc-resume</span>
                    <span class="shell-desc">Pick a session to resume</span>
                </li>
                <li>
                    <span class="shell-cmd">cc-help</span>
                    <span class="shell-desc">Show all commands</span>
                </li>
            </ul>
        </div>

    </div>

    <a href="/" class="home-btn" aria-label="Go to home page">
        <span aria-hidden="true">&#x1f3e0;</span>
        <span>Back to Home</span>
    </a>

    <footer class="footer">
        <p class="footer-text"><a href="https://github.com/RandomSynergy17/ClaudePantheon">GitHub</a> &middot; Access Claude Code from any device with a web browser</p>
        <p class="footer-credit">A RandomSynergy Production</p>
    </footer>

</body>
</html>
