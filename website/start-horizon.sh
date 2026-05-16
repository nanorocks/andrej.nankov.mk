#!/bin/bash
# start-horizon.sh
#
# Starts Laravel Horizon in the BACKGROUND on cPanel using the globally available
# `supervisor` binary. Logs go to storage/logs/horizon.log.
#
# supervisor behaviour:
#   - Restarts Horizon automatically on crash (non-zero exit)
#   - Does NOT restart on clean stop: php artisan horizon:terminate (exit 0)
#   - Restarts when a *.restart file is touched in storage/framework/horizon/
#
# Usage:
#   bash start-horizon.sh          # start in background
#   bash start-horizon.sh stop     # stop the background process
#   bash start-horizon.sh status   # check if running

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

PID_FILE="storage/logs/horizon.pid"
LOG_FILE="storage/logs/horizon.log"

mkdir -p storage/framework/horizon
mkdir -p storage/logs

# ── stop ──────────────────────────────────────────────────────────────────────
if [ "$1" = "stop" ]; then
    if [ -f "$PID_FILE" ]; then
        PID=$(cat "$PID_FILE")
        if kill -0 "$PID" 2>/dev/null; then
            php artisan horizon:terminate 2>/dev/null
            sleep 2
            kill "$PID" 2>/dev/null
            rm -f "$PID_FILE"
            echo "[horizon] Stopped (PID $PID)"
        else
            echo "[horizon] Not running (stale PID file removed)"
            rm -f "$PID_FILE"
        fi
    else
        echo "[horizon] Not running (no PID file)"
    fi
    exit 0
fi

# ── status ────────────────────────────────────────────────────────────────────
if [ "$1" = "status" ]; then
    if [ -f "$PID_FILE" ]; then
        PID=$(cat "$PID_FILE")
        if kill -0 "$PID" 2>/dev/null; then
            echo "[horizon] Running (PID $PID)"
            echo "[horizon] Log: tail -f $LOG_FILE"
        else
            echo "[horizon] Not running (stale PID file)"
        fi
    else
        echo "[horizon] Not running"
    fi
    exit 0
fi

# ── start ─────────────────────────────────────────────────────────────────────
if [ -f "$PID_FILE" ]; then
    PID=$(cat "$PID_FILE")
    if kill -0 "$PID" 2>/dev/null; then
        echo "[horizon] Already running (PID $PID)"
        echo "[horizon] To restart: touch storage/framework/horizon/horizon.restart"
        echo "[horizon] To stop:    bash start-horizon.sh stop"
        exit 0
    fi
    rm -f "$PID_FILE"
fi

nohup supervisor \
    --no-restart-on exit \
    --watch "storage/framework/horizon" \
    --extensions "restart" \
    --exec php \
    -- artisan horizon \
    >> "$LOG_FILE" 2>&1 &

echo $! > "$PID_FILE"

echo "[horizon] Started in background (PID $(cat $PID_FILE))"
echo "[horizon] Log:     tail -f $LOG_FILE"
echo "[horizon] Restart: touch storage/framework/horizon/horizon.restart"
echo "[horizon] Stop:    bash start-horizon.sh stop"
