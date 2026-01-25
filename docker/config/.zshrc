# ╔═══════════════════════════════════════════════════════════╗
# ║                    ClaudePantheon                         ║
# ║              ZSH Configuration                            ║
# ╚═══════════════════════════════════════════════════════════╝
# Custom configuration for persistent Claude sessions

# Oh My Zsh configuration
export ZSH="$HOME/.oh-my-zsh"

# Theme - use a clean, informative theme
ZSH_THEME="robbyrussell"

# Plugins
plugins=(
    git
    docker
    docker-compose
    npm
    node
    python
    pip
    zsh-autosuggestions
    zsh-syntax-highlighting
    history
    sudo
    web-search
    copypath
    copyfile
    jsontools
)

source $ZSH/oh-my-zsh.sh

# ─────────────────────────────────────────────────────────────
# Environment Variables
# ─────────────────────────────────────────────────────────────

export WORKSPACE_DIR="${WORKSPACE_DIR:-/home/claude/workspace}"
export EDITOR="nano"
export VISUAL="nano"
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8

# Claude Code specific
export CLAUDE_CODE_ENTRYPOINT="cli"

# History configuration
export HISTFILE="/home/claude/.zsh_history_dir/.zsh_history"
export HISTSIZE=50000
export SAVEHIST=50000
setopt SHARE_HISTORY
setopt HIST_EXPIRE_DUPS_FIRST
setopt HIST_IGNORE_DUPS
setopt HIST_IGNORE_SPACE
setopt HIST_VERIFY

# ─────────────────────────────────────────────────────────────
# Claude Code Aliases & Functions
# ─────────────────────────────────────────────────────────────

# Main Claude commands
alias cc='cd $WORKSPACE_DIR && claude --continue'
alias cc-new='cd $WORKSPACE_DIR && claude'
alias cc-resume='cd $WORKSPACE_DIR && claude --resume'
alias cc-list='cd $WORKSPACE_DIR && claude --resume'
alias cch='claude --help'

# Quick actions
alias ccw='cd $WORKSPACE_DIR'  # Go to workspace
alias cce='$EDITOR $WORKSPACE_DIR/CLAUDE.md'  # Edit CLAUDE.md
alias ccm='$EDITOR ~/.config/claude-code/mcp.json'  # Edit MCP config

# Session management
cc-setup() {
    /home/claude/scripts/shell-wrapper.sh --setup
}

# ─────────────────────────────────────────────────────────────
# General Aliases
# ─────────────────────────────────────────────────────────────

# Navigation
alias ..='cd ..'
alias ...='cd ../..'
alias ....='cd ../../..'
alias ws='cd $WORKSPACE_DIR'

# Listing
alias ll='ls -alF'
alias la='ls -A'
alias l='ls -CF'
alias lt='ls -alFtr'  # Sort by time, newest last

# Safety
alias rm='rm -i'
alias cp='cp -i'
alias mv='mv -i'

# Git shortcuts
alias gs='git status'
alias ga='git add'
alias gc='git commit'
alias gp='git push'
alias gl='git pull'
alias gd='git diff'
alias glog='git log --oneline --graph --decorate -20'

# Docker shortcuts
alias dps='docker ps'
alias dpsa='docker ps -a'
alias dimg='docker images'
alias dlogs='docker logs -f'

# Quick edit
alias zshrc='$EDITOR ~/.zshrc && source ~/.zshrc'

# System info
alias ports='netstat -tulanp'
alias meminfo='free -h'
alias diskinfo='df -h'

# ─────────────────────────────────────────────────────────────
# Custom Functions
# ─────────────────────────────────────────────────────────────

# Create and enter directory
mkcd() {
    mkdir -p "$1" && cd "$1"
}

# Search in files
search() {
    grep -rn "$1" "${2:-.}"
}

# Quick backup
backup() {
    cp "$1" "$1.backup.$(date +%Y%m%d%H%M%S)"
}

# Show Claude session info
cc-info() {
    echo ""
    echo "╔═══════════════════════════════════════════╗"
    echo "║         ClaudePantheon Status             ║"
    echo "╚═══════════════════════════════════════════╝"
    echo ""
    echo "Workspace:     $WORKSPACE_DIR"
    echo "Claude Config: ~/.config/claude-code/"
    echo "MCP Config:    ~/.config/claude-code/mcp.json"
    echo "CLAUDE.md:     $WORKSPACE_DIR/CLAUDE.md"
    echo ""
    echo "Claude Version: $(claude --version 2>/dev/null || echo 'not installed')"
    echo "Node Version:   $(node --version 2>/dev/null || echo 'not installed')"
    echo ""
    if [ -n "${ANTHROPIC_API_KEY:-}" ]; then
        echo "API Key:        Set (${#ANTHROPIC_API_KEY} chars)"
    else
        echo "API Key:        Not set (will prompt for auth)"
    fi
    echo ""
}

# Help for Claude commands
cc-help() {
    echo ""
    echo "╔═══════════════════════════════════════════════════════════╗"
    echo "║           Claude Code Commands Reference                  ║"
    echo "╚═══════════════════════════════════════════════════════════╝"
    echo ""
    echo "Session Commands:"
    echo "  cc          Continue last Claude conversation"
    echo "  cc-new      Start a fresh Claude conversation"
    echo "  cc-resume   Pick a session to resume"
    echo "  cc-list     List available sessions"
    echo ""
    echo "Configuration:"
    echo "  cc-setup    Run the CLAUDE.md setup wizard"
    echo "  cc-info     Show environment information"
    echo "  cce         Edit CLAUDE.md"
    echo "  ccm         Edit MCP configuration"
    echo ""
    echo "Navigation:"
    echo "  ccw         Go to workspace directory"
    echo "  ws          Same as ccw"
    echo ""
    echo "For Claude Code help: claude --help"
    echo ""
}

# ─────────────────────────────────────────────────────────────
# Custom Prompt
# ─────────────────────────────────────────────────────────────

# Override prompt for ClaudePantheon environment
PROMPT='%{$fg[cyan]%}[pantheon]%{$reset_color%} %{$fg[green]%}%~%{$reset_color%} $(git_prompt_info)
%{$fg[yellow]%}➜%{$reset_color%} '

ZSH_THEME_GIT_PROMPT_PREFIX="%{$fg[blue]%}git:(%{$fg[red]%}"
ZSH_THEME_GIT_PROMPT_SUFFIX="%{$reset_color%} "
ZSH_THEME_GIT_PROMPT_DIRTY="%{$fg[blue]%}) %{$fg[yellow]%}✗"
ZSH_THEME_GIT_PROMPT_CLEAN="%{$fg[blue]%})"

# ─────────────────────────────────────────────────────────────
# Startup Message
# ─────────────────────────────────────────────────────────────

# Only show on interactive shells
if [[ $- == *i* ]]; then
    echo ""
    echo "Type 'cc' to continue your last Claude session"
    echo "Type 'cc-help' for all commands"
    echo ""
fi
