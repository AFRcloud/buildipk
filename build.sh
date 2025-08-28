#!/bin/sh
# =====================================================
# Skrip Build IPK untuk GitHub Actions
# =====================================================

set -e

PKGNAME="hotspot-themes"
VERSION=$(date +%Y%m%d-%H%M) # Versi berdasarkan tanggal
ARCH="all"
WORKDIR="hotspot-pkg"

echo "======================================"
echo "HOTSPOT THEME IPK BUILD LOG"
echo "======================================"

echo "[*] Bersihkan direktori kerja..."
rm -rf "$WORKDIR"
mkdir -p "$WORKDIR"

# Salin file ke struktur build
echo "[*] Salin file ke struktur build..."
cp -r data/ "$WORKDIR/"
cp control "$WORKDIR/CONTROL"

# Buat file postinst
echo "[*] Buat file postinst..."
cat > "$WORKDIR/CONTROL/postinst" << "EOP"
#!/bin/sh
uci set chilli.@chilli[0].uamserver='http://192.168.1.1/loginpage.php'
uci commit chilli
/etc/init.d/chilli restart
exit 0
EOP
chmod 755 "$WORKDIR/CONTROL/postinst"

# Build IPK menggunakan opkg-build
echo "[*] Build IPK..."
mkdir -p output/packages
opkg-build "$WORKDIR" output/packages

echo "[OK] IPK selesai. File ada di output/packages"

