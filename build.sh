#!/bin/sh

set -e

PKGNAME="hotspot-themes"
VERSION=$(date +%Y%m%d-%H%M)
ARCH="all"
WORKDIR="build"
OUTDIR="output"

echo "======================================"
echo "HOTSPOT THEME IPK BUILD LOG"
echo "======================================"

echo "[*] Cleaning up build directories..."
rm -rf "$WORKDIR" "$OUTDIR"
mkdir -p "$WORKDIR/CONTROL" "$WORKDIR/data/www" "$OUTDIR/packages"

echo "[*] Copying files to build directory..."
cp -r CONTROL/* "$WORKDIR/CONTROL/"
cp -r data/www/* "$WORKDIR/data/www/"

# Create postinst file
echo "[*] Creating postinst file..."
cat > "$WORKDIR/CONTROL/postinst" << "EOP"
#!/bin/sh
uci set chilli.@chilli[0].uamserver='http://192.168.1.1/loginpage.php'
uci commit chilli
/etc/init.d/chilli restart
exit 0
EOP
chmod 755 "$WORKDIR/CONTROL/postinst"

echo "[*] Building IPK package..."
opkg-build "$WORKDIR" "$OUTDIR/packages"

echo "[OK] IPK build successful. File location: $OUTDIR/packages"
