if [[ "$1" == apache2* ]] || [ "$1" == php-fpm ]; then
    [[ ! -f "${JENTIL_DIR}/functions.php" ]] && \
        echo >&2 "'jentil' theme not found. Installing..." && \
        cp -rf "/usr/src/jentil/" "${JENTIL_DIR}/" &&
        rm -rf "${JENTIL_DIR}/docker/" && \
        echo >&2 "Done! Theme installed successfully to '${JENTIL_DIR}'"
fi

exec "$@"
