# 🏛️ ClaudePantheon

> *A temple for your persistent Claude Code sessions*

A Docker-based, always-on Claude Code environment with web terminal access, oh-my-zsh, MCP integrations, and automatic session continuity.

```
╔═══════════════════════════════════════════════════════════╗
║                    ClaudePantheon                         ║
║     Project Hospitality - We implement. Not just advise.  ║
╚═══════════════════════════════════════════════════════════╝
```

## ✨ Features

- 🔄 **Persistent Sessions** - All conversations continue from where you left off
- 🌐 **Web Terminal Access** - Connect via browser using ttyd
- 🐚 **Oh My Zsh** - Beautiful, functional shell with plugins
- 🔌 **MCP Ready** - Pre-configured for Model Context Protocol integrations
- 📁 **Volume Mapped** - Your files persist across container restarts
- 🔐 **Secure** - Optional authentication for web terminal
- 🚀 **Auto-Setup** - Interactive wizard builds your CLAUDE.md on first run

## 🚀 Quick Start

### 1. Clone and Configure

```bash
cd claudepantheon

# Create your environment file
cp .env.example .env

# Edit with your settings
nano .env
```

### 2. Configure Authentication

**Option A: API Key (Recommended)**
```bash
# Add to .env
ANTHROPIC_API_KEY=sk-ant-api03-xxxxx
```

**Option B: Claude Max Subscription**
Leave `ANTHROPIC_API_KEY` blank - Claude will prompt for browser authentication.

### 3. Secure Your Terminal

```bash
# Add to .env (required for any network exposure)
TTYD_CREDENTIAL=yourusername:yourpassword
```

### 4. Build and Start

```bash
# Build the image
make build

# Start ClaudePantheon
make up

# View logs
make logs
```

### 5. Connect

Open your browser: **http://localhost:7681**

Complete the setup wizard, then type `cc` to enter the Pantheon!

## 📜 Commands

| Command | Description |
|---------|-------------|
| `cc` | Continue last Claude conversation |
| `cc-new` | Start a fresh session |
| `cc-resume` | Pick a specific session to resume |
| `cc-list` | List available sessions |
| `cc-setup` | Re-run the CLAUDE.md setup wizard |
| `cc-mcp` | Manage MCP server configurations |
| `cc-info` | Show environment information |
| `cc-help` | Show all available commands |

## 📁 Directory Structure

```
/home/claude/
├── workspace/          # Your projects (mounted volume)
│   └── CLAUDE.md      # Project context for Claude
├── .claude/           # Session history (persistent volume)
├── .config/
│   └── claude-code/
│       └── mcp.json   # MCP server configuration
├── scripts/           # Helper scripts
└── .zshrc            # Shell configuration
```

## 💾 Volume Mappings

| Host Path | Container Path | Purpose |
|-----------|----------------|---------|
| `./workspace` | `/home/claude/workspace` | Your projects |
| `./config/claude-code` | `/home/claude/.config/claude-code` | MCP config |
| `./config/ssh` | `/home/claude/.ssh` | SSH keys |
| `./config/.gitconfig` | `/home/claude/.gitconfig` | Git config |
| `pantheon-history` | `/home/claude/.claude` | Session history |

## 🔌 MCP Configuration

Edit `./config/claude-code/mcp.json` to add MCP servers:

```json
{
  "mcpServers": {
    "github": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-github"],
      "env": {
        "GITHUB_PERSONAL_ACCESS_TOKEN": "your-token"
      }
    },
    "home-assistant": {
      "command": "npx",
      "args": ["-y", "mcp-server-home-assistant"],
      "env": {
        "HASS_HOST": "http://hass.randomsynergy.xyz",
        "HASS_TOKEN": "your-token"
      }
    }
  }
}
```

### Available MCP Servers

| Server | Package | Use Case |
|--------|---------|----------|
| Filesystem | `@modelcontextprotocol/server-filesystem` | Extended file access |
| GitHub | `@modelcontextprotocol/server-github` | Repos, issues, PRs |
| PostgreSQL | `@modelcontextprotocol/server-postgres` | Database queries |
| Brave Search | `@modelcontextprotocol/server-brave-search` | Web search |
| Memory | `@modelcontextprotocol/server-memory` | Persistent memory |
| Puppeteer | `@modelcontextprotocol/server-puppeteer` | Browser automation |
| Home Assistant | `mcp-server-home-assistant` | Smart home |
| Notion | `mcp-notion` | Workspace |

## 🔒 Security

### Essential Configuration

1. **Always set TTYD_CREDENTIAL** - Prevents unauthorized access
2. **Use a reverse proxy** - Add HTTPS with nginx/Caddy
3. **Limit port exposure** - Only expose ports you need

### Adding HTTPS with Caddy

```
claudepantheon.yourdomain.com {
    reverse_proxy localhost:7681
}
```

### Remote Access Options

- **Tailscale** - Add to your tailnet for secure access
- **Cloudflare Tunnel** - Zero-trust access without port forwarding
- **VPN** - Access via your network VPN

## 🛠️ Makefile Commands

```bash
make build    # Build the Docker image
make up       # Start ClaudePantheon
make down     # Stop the container
make logs     # View logs
make shell    # Get a shell in the container
make restart  # Restart the container
make status   # Show container status
make backup   # Backup volumes and workspace
make update   # Update Claude Code to latest
make clean    # Remove container and images (keeps volumes)
make purge    # Remove everything including volumes
```

## 🔧 Troubleshooting

### Session Not Persisting

Check the volume mount:
```bash
docker volume ls | grep pantheon
docker volume inspect claudepantheon-history
```

### Claude Not Authenticated

For API key auth:
```bash
docker compose exec claudepantheon env | grep ANTHROPIC
```

For browser auth:
```bash
docker compose exec claudepantheon claude auth login
```

### MCP Servers Not Working

1. Check config: `cat ~/.config/claude-code/mcp.json | jq .`
2. Test manually: `npx -y @modelcontextprotocol/server-github`
3. Check status in Claude: `claude mcp`

## 🏗️ Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    Your Browser                              │
│                  http://localhost:7681                       │
└─────────────────────┬───────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                     ttyd                                     │
│              (Web Terminal Server)                           │
└─────────────────────┬───────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                   oh-my-zsh                                  │
│         (with custom aliases: cc, cc-new, etc.)              │
└─────────────────────┬───────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                 Claude Code                                  │
│    --continue flag ensures session persistence               │
└─────────────────────┬───────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                  MCP Servers                                 │
│    (GitHub, Home Assistant, Postgres, etc.)                  │
└─────────────────────────────────────────────────────────────┘
```

## 📄 License

MIT - Do whatever you want with it!

---

<p align="center">
Built with ❤️ for persistent Claude Code workflows.<br>
<em>"We implement. Not just advise."</em> - Project Hospitality
</p>
