# ╔═══════════════════════════════════════════════════════════╗
# ║                    ClaudePantheon                         ║
# ║     Persistent Claude Code Environment with Web Access    ║
# ╚═══════════════════════════════════════════════════════════╝
# 
# A temple for your persistent Claude Code sessions
# With ttyd web terminal, ohmyzsh, and MCP support

FROM node:22-bookworm

LABEL maintainer="Project Hospitality"
LABEL description="ClaudePantheon - Persistent Claude Code environment with web terminal access"
LABEL project="ClaudePantheon"

# Build arguments
ARG USERNAME=claude
ARG USER_UID=1000
ARG USER_GID=1000

# Environment variables
ENV DEBIAN_FRONTEND=noninteractive
ENV SHELL=/bin/zsh
ENV TERM=xterm-256color
ENV CLAUDE_CODE_ENTRYPOINT=cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    # Core utilities
    git \
    curl \
    wget \
    vim \
    nano \
    htop \
    tree \
    jq \
    unzip \
    zip \
    # Shell and terminal
    zsh \
    tmux \
    # Network tools
    openssh-server \
    net-tools \
    iputils-ping \
    dnsutils \
    # Development tools
    build-essential \
    python3 \
    python3-pip \
    python3-venv \
    # ttyd dependencies
    cmake \
    libjson-c-dev \
    libwebsockets-dev \
    # Additional utilities
    sudo \
    locales \
    ca-certificates \
    gnupg \
    && rm -rf /var/lib/apt/lists/*

# Set up locale
RUN sed -i '/en_US.UTF-8/s/^# //g' /etc/locale.gen && locale-gen
ENV LANG=en_US.UTF-8
ENV LANGUAGE=en_US:en
ENV LC_ALL=en_US.UTF-8

# Install ttyd from release (more reliable than building)
RUN wget -O /usr/local/bin/ttyd https://github.com/tsl0922/ttyd/releases/download/1.7.7/ttyd.x86_64 \
    && chmod +x /usr/local/bin/ttyd

# Create user with sudo access
RUN groupadd --gid ${USER_GID} ${USERNAME} \
    && useradd --uid ${USER_UID} --gid ${USER_GID} -m ${USERNAME} -s /bin/zsh \
    && echo "${USERNAME} ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers.d/${USERNAME} \
    && chmod 0440 /etc/sudoers.d/${USERNAME}

# Set up SSH
RUN mkdir /var/run/sshd \
    && sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin no/' /etc/ssh/sshd_config \
    && sed -i 's/#PasswordAuthentication yes/PasswordAuthentication yes/' /etc/ssh/sshd_config

# Switch to user for remaining setup
USER ${USERNAME}
WORKDIR /home/${USERNAME}

# Install oh-my-zsh
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" "" --unattended

# Install zsh plugins
RUN git clone https://github.com/zsh-users/zsh-autosuggestions ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-autosuggestions \
    && git clone https://github.com/zsh-users/zsh-syntax-highlighting ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-syntax-highlighting

# Install Claude Code globally
RUN npm install -g @anthropic-ai/claude-code

# Create directory structure
RUN mkdir -p \
    /home/${USERNAME}/workspace \
    /home/${USERNAME}/.claude \
    /home/${USERNAME}/.config/claude-code \
    /home/${USERNAME}/.ssh \
    /home/${USERNAME}/scripts

# Copy configuration files (will be done after COPY commands)
USER root

# Copy scripts and configs
COPY --chown=${USERNAME}:${USERNAME} scripts/ /home/${USERNAME}/scripts/
COPY --chown=${USERNAME}:${USERNAME} config/.zshrc /home/${USERNAME}/.zshrc
COPY --chown=${USERNAME}:${USERNAME} config/claude-mcp.json /home/${USERNAME}/.config/claude-code/mcp.json

# Make scripts executable
RUN chmod +x /home/${USERNAME}/scripts/*.sh

# Switch back to user
USER ${USERNAME}

# Expose ports
# 7681 - ttyd web terminal
# 22 - SSH (optional)
EXPOSE 7681 22

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:7681/ || exit 1

# Entry point
ENTRYPOINT ["/home/claude/scripts/entrypoint.sh"]
