# Workspace

This is your persistent workspace directory. All projects and files you create here will persist across container restarts.

## Structure

```
workspace/
├── CLAUDE.md          # Auto-generated project context (after setup)
└── your-projects/     # Your work goes here
```

## Getting Started

1. Start the container: `make up`
2. Connect via browser: `http://localhost:7681`
3. Run through the setup wizard
4. Type `cc` to start/continue your Claude session

## Tips

- Use `cc` to continue your last conversation
- Use `cc-new` for a fresh session
- Edit `CLAUDE.md` to update project context
- All files here are accessible in Claude Code
