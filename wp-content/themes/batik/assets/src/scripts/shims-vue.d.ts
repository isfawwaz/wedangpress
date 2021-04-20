declare module '*.vue' {
    import Vue from 'vue';
    export default Vue;
}

declare module '*.svg' {
    import Vue, { VueConstructor } from 'vue';
    const content: VueConstructor<Vue>;
    export default content;
}

// Example for 3rd party declaration
declare module 'vue-image-brightness' {
    export default class VueImageBrightness {
        static install(Vue: any, options?: any[]): void;
    }
}
