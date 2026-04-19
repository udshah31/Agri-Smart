#!/bin/bash
# ============================================
# AgriSmart - Quick Setup Script
# Run this on a fresh machine to set up everything
# Usage: bash setup.sh
# ============================================

set -e
echo ""
echo "🌾 =================================="
echo "   AgriSmart - Setup Script"
echo "🌾 =================================="
echo ""

# --- Check PHP ---
echo "1️⃣  Checking PHP..."
if command -v php &> /dev/null; then
    PHP_VER=$(php -v | head -1)
    echo "   ✅ $PHP_VER"
else
    echo "   ❌ PHP not found!"
    echo "   Install: brew install php (Mac) | apt install php (Linux) | Download XAMPP (Windows)"
    exit 1
fi

# --- Check MySQL ---
echo "2️⃣  Checking MySQL..."
if command -v mysql &> /dev/null; then
    MYSQL_VER=$(mysql --version 2>/dev/null)
    echo "   ✅ $MYSQL_VER"
else
    echo "   ⚠️  MySQL CLI not found (XAMPP users: that's OK, use phpMyAdmin instead)"
fi

# --- Check Python ---
echo "3️⃣  Checking Python..."
if command -v python3 &> /dev/null; then
    PY_VER=$(python3 --version)
    echo "   ✅ $PY_VER"
else
    echo "   ❌ Python3 not found!"
    echo "   Install: brew install python3 (Mac) | apt install python3 (Linux)"
    exit 1
fi

# --- Setup Python Virtual Environment ---
echo "4️⃣  Setting up Python virtual environment..."
if [ ! -d "venv" ]; then
    python3 -m venv venv
    echo "   ✅ Created venv/"
else
    echo "   ✅ venv/ already exists"
fi

echo "5️⃣  Installing Python dependencies..."
venv/bin/pip install --quiet -r requirements.txt
echo "   ✅ Installed: pandas, numpy, matplotlib, scikit-learn, joblib"

# --- Verify ML works ---
echo "6️⃣  Verifying ML libraries..."
venv/bin/python -c "import sklearn, pandas, numpy; print('   ✅ All ML libraries OK')"

# --- Database Setup ---
echo "7️⃣  Database setup..."
echo "   Attempting to create database 'ecometrics'..."
if command -v mysql &> /dev/null; then
    read -p "   Enter MySQL username [root]: " DB_USER
    DB_USER=${DB_USER:-root}
    read -sp "   Enter MySQL password (empty = no password): " DB_PASS
    echo ""
    
    if [ -z "$DB_PASS" ]; then
        mysql -u "$DB_USER" -e "CREATE DATABASE IF NOT EXISTS ecometrics;" 2>/dev/null && \
        mysql -u "$DB_USER" ecometrics < "database/ecometrics (3).sql" 2>/dev/null && \
        echo "   ✅ Database imported successfully!" || \
        echo "   ⚠️  Could not auto-import. Please import manually via phpMyAdmin."
    else
        mysql -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS ecometrics;" 2>/dev/null && \
        mysql -u "$DB_USER" -p"$DB_PASS" ecometrics < "database/ecometrics (3).sql" 2>/dev/null && \
        echo "   ✅ Database imported successfully!" || \
        echo "   ⚠️  Could not auto-import. Please import manually via phpMyAdmin."
    fi
else
    echo "   ⚠️  MySQL CLI not available. Please import the database manually:"
    echo "      1. Open phpMyAdmin (http://localhost/phpmyadmin)"
    echo "      2. Create database: ecometrics"
    echo "      3. Import: database/ecometrics (3).sql"
fi

echo ""
echo "🌾 =================================="
echo "   Setup Complete!"
echo "🌾 =================================="
echo ""
echo "To start the application, run:"
echo ""
echo "   php -S localhost:8035"
echo ""
echo "Then open: http://localhost:8035"
echo ""
