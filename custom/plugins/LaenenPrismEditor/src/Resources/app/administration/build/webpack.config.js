const { join, resolve } = require('path');
const fs = require('fs')

module.exports = () => {

    // Find Shopware root path
    let path = __dirname;
    let rootPath = null;
    let steps = 0;
    while (rootPath === null) {
        steps++;
        if (steps > 50) {
            rootPath = false;
        }

        const lastIndex = path.lastIndexOf('/');
        path = path.substr(0, lastIndex) + '/.env'

        if (fs.existsSync(path)) {
            rootPath = join(path.substr(0, lastIndex), 'vendor', 'shopware', 'administration', 'Resources', 'app', 'administration', 'node_modules');

            if (!fs.existsSync(rootPath)) {
                rootPath = join(path.substr(0, lastIndex), 'vendor', 'shopware', 'platform', 'src', 'Administration', 'Resources', 'app', 'administration', 'node_modules');
            }

            if (!fs.existsSync(rootPath)) {
                rootPath = false;
            }
        } else {
            path = path.substr(0, lastIndex);
        }
    }

    return {
        resolve: {
            alias: {
                '@vue-prism-editor': resolve(
                    join(__dirname, '..', 'node_modules', 'vue-prism-editor')
                ),
                '@prismjs': resolve(
                    join(__dirname, '..', 'node_modules', 'prismjs')
                ),
                'vue': resolve(
                    join(rootPath, 'vue')
                )
            }
        }
    };
}
