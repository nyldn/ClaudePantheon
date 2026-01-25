# ╔═══════════════════════════════════════════════════════════╗
# ║                    ClaudePantheon                         ║
# ║              Makefile for Docker Management               ║
# ╚═══════════════════════════════════════════════════════════╝

.PHONY: help build up down logs shell restart clean status backup update

# Default target
help:
	@echo ""
	@echo "🏛️  ClaudePantheon"
	@echo "═══════════════════════════════════════"
	@echo ""
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets:"
	@echo "  build      Build the Docker image"
	@echo "  up         Start ClaudePantheon (detached)"
	@echo "  down       Stop ClaudePantheon"
	@echo "  restart    Restart the container"
	@echo "  logs       Show container logs (follow mode)"
	@echo "  shell      Open a shell in the container"
	@echo "  status     Show container status"
	@echo "  backup     Backup volumes and workspace"
	@echo "  update     Update Claude Code to latest version"
	@echo "  clean      Remove container and images (keeps volumes)"
	@echo "  purge      Remove everything including volumes (!)"
	@echo ""
	@echo "Quick start:"
	@echo "  1. cp .env.example .env"
	@echo "  2. Edit .env with your settings"
	@echo "  3. make build"
	@echo "  4. make up"
	@echo "  5. Open http://localhost:7681"
	@echo ""

# Build the Docker image
build:
	@echo "🏗️  Building ClaudePantheon..."
	docker compose build

# Start the container
up:
	@echo "🚀 Starting ClaudePantheon..."
	docker compose up -d
	@echo ""
	@echo "🏛️  ClaudePantheon is ready!"
	@echo "   Access at: http://localhost:7681"
	@echo "   Use 'make logs' to view output"

# Stop the container
down:
	@echo "⏹️  Stopping ClaudePantheon..."
	docker compose down

# Show logs
logs:
	docker compose logs -f

# Open shell in container
shell:
	docker compose exec claudepantheon /bin/zsh

# Restart container
restart:
	@echo "🔄 Restarting ClaudePantheon..."
	docker compose restart
	@echo "✅ ClaudePantheon restarted!"

# Show status
status:
	@echo ""
	@echo "🏛️  ClaudePantheon Status:"
	@docker compose ps
	@echo ""
	@echo "📦 Volumes:"
	@docker volume ls | grep pantheon
	@echo ""
	@echo "📊 Resources:"
	@docker stats --no-stream claudepantheon 2>/dev/null || echo "Container not running"

# Backup data
backup:
	@echo "💾 Creating backup..."
	@mkdir -p backups
	@BACKUP_NAME="backup_$$(date +%Y%m%d_%H%M%S)"; \
	mkdir -p "backups/$$BACKUP_NAME"; \
	cp -r workspace "backups/$$BACKUP_NAME/" 2>/dev/null || true; \
	cp -r config "backups/$$BACKUP_NAME/" 2>/dev/null || true; \
	docker run --rm -v claudepantheon-history:/data -v $$(pwd)/backups/$$BACKUP_NAME:/backup alpine tar czf /backup/pantheon-history.tar.gz -C /data . 2>/dev/null || true; \
	echo "✅ Backup created: backups/$$BACKUP_NAME"

# Update Claude Code
update:
	@echo "⬆️  Updating Claude Code..."
	docker compose exec claudepantheon npm update -g @anthropic-ai/claude-code
	@echo "✅ Claude Code updated!"

# Clean up (preserves volumes)
clean:
	@echo "🧹 Cleaning up containers and images..."
	docker compose down --rmi local
	@echo "✅ Cleanup complete! Volumes preserved."

# Full purge (removes everything!)
purge:
	@echo "⚠️  WARNING: This will delete ALL data including session history!"
	@read -p "Are you sure? (type 'yes' to confirm): " confirm; \
	if [ "$$confirm" = "yes" ]; then \
		docker compose down -v --rmi local; \
		docker volume rm claudepantheon-history claudepantheon-zsh-history claudepantheon-node-cache claudepantheon-python-venvs 2>/dev/null || true; \
		echo "✅ Full purge complete!"; \
	else \
		echo "❌ Cancelled."; \
	fi

# Quick rebuild
rebuild: down build up
	@echo "✅ Rebuild complete!"

# Development mode (foreground with logs)
dev:
	docker compose up

# Check health
health:
	@curl -s -o /dev/null -w "%{http_code}" http://localhost:7681/ && echo " - ttyd is responding" || echo " - ttyd not responding"

# Show Claude Code version
version:
	docker compose exec claudepantheon claude --version

# Initialize (first time setup)
init:
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
		echo "✅ Created .env from template."; \
		echo "📝 Please edit it with your settings."; \
		echo "Then run: make build && make up"; \
	else \
		echo "ℹ️  .env already exists."; \
		echo "Edit it as needed, then run: make build && make up"; \
	fi
