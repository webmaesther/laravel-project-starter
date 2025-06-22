import { defineConfig, mergeConfig } from 'vitest/config';
import { baseConfig } from './vite.config';

export default mergeConfig(
    baseConfig,
    defineConfig({
        test: {
            include: ['tests/Frontend/**/*.test.ts'],
            environment: 'happy-dom',
            setupFiles: ['tests/Frontend/setup.ts'],
        },
    }),
);
