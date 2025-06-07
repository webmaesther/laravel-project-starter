import { defineConfig, mergeConfig } from 'vitest/config';
import viteConfig from './vite.config';

export default mergeConfig(
    viteConfig,
    defineConfig({
        test: {
            include: ['tests/Frontend/**/*.test.ts'],
            environment: 'happy-dom',
            setupFiles: ['tests/Frontend/setup.ts'],
        },
    }),
);
