if [[ "$1" == apache2* ]] || [ "$1" == php-fpm ]; then
    [[ ! -f "${THEME_DIR}/functions.php" ]] && \
        echo >&2 "'${THEME_NAME}' theme not found. Installing..." && \
        cp -rf "/usr/src/${THEME_NAME}/" "${THEME_DIR}/" &&
        rm -rf "${THEME_DIR}/docker/" && \
        echo >&2 "Done! Theme installed successfully to '${THEME_DIR}'"
fi

exec "$@"
