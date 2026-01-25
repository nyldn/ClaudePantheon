#!/bin/bash
# ╔═══════════════════════════════════════════════════════════╗
# ║                    ClaudePantheon                         ║
# ║              Entrypoint Script                            ║
# ╚═══════════════════════════════════════════════════════════╝
# Handles first-run setup, session persistence, and service startup

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Configuration
WORKSPACE_DIR="${WORKSPACE_DIR:-/home/claude/workspace}"
CLAUDE_DIR="/home/claude/.claude"
CONFIG_DIR="/home/claude/.config/claude-code"
FIRST_RUN_FLAG="/home/claude/.claude/.initialized"
CLAUDE_MD_PATH="${WORKSPACE_DIR}/CLAUDE.md"

# Logging function
log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

warn() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Ensure directories exist with proper permissions
setup_directories() {
    log "Setting up directories..."
    mkdir -p "${WORKSPACE_DIR}"
    mkdir -p "${CLAUDE_DIR}"
    mkdir -p "${CONFIG_DIR}"
    mkdir -p "/home/claude/.zsh_history_dir"
    
    # Link zsh history to persistent volume
    if [ ! -L "/home/claude/.zsh_history" ]; then
        ln -sf "/home/claude/.zsh_history_dir/.zsh_history" "/home/claude/.zsh_history" 2>/dev/null || true
    fi
}

# Check if this is first run
is_first_run() {
    [ ! -f "${FIRST_RUN_FLAG}" ]
}

# Mark as initialized
mark_initialized() {
    touch "${FIRST_RUN_FLAG}"
    log "Environment initialized successfully"
}

# Verify Claude Code installation
verify_claude() {
    if ! command -v claude &> /dev/null; then
        error "Claude Code not found. Installing..."
        npm install -g @anthropic-ai/claude-code
    fi
    log "Claude Code version: $(claude --version 2>/dev/null || echo 'unknown')"
}

# Setup SSH server (optional)
setup_ssh() {
    if [ -n "${ENABLE_SSH:-}" ]; then
        log "Starting SSH server..."
        sudo /usr/sbin/sshd
    fi
}

# Start ttyd with appropriate settings
start_ttyd() {
    local TTYD_ARGS="-p ${TTYD_PORT:-7681}"
    
    # Add authentication if configured
    if [ -n "${TTYD_CREDENTIAL:-}" ]; then
        TTYD_ARGS="${TTYD_ARGS} -c ${TTYD_CREDENTIAL}"
        log "ttyd authentication enabled"
    else
        warn "ttyd running without authentication - consider setting TTYD_CREDENTIAL"
    fi
    
    # Additional ttyd options
    TTYD_ARGS="${TTYD_ARGS} -t fontSize=14"
    TTYD_ARGS="${TTYD_ARGS} -t fontFamily='JetBrains Mono, Menlo, Monaco, monospace'"
    TTYD_ARGS="${TTYD_ARGS} -t theme={'background':'#1e1e2e','foreground':'#cdd6f4'}"
    
    log "Starting ttyd on port ${TTYD_PORT:-7681}..."
    exec ttyd ${TTYD_ARGS} /home/claude/scripts/shell-wrapper.sh
}

# Main execution
main() {
    echo ""
    echo -e "${CYAN}╔═══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║                    ClaudePantheon                         ║${NC}"
    echo -e "${CYAN}║     Project Hospitality - We implement. Not just advise.  ║${NC}"
    echo -e "${CYAN}╚═══════════════════════════════════════════════════════════╝${NC}"
    echo ""
    
    setup_directories
    verify_claude
    setup_ssh
    
    if is_first_run; then
        log "First run detected - setup wizard will launch on first terminal connection"
    else
        log "Existing installation detected - resuming previous session"
    fi
    
    start_ttyd
}

main "$@"
