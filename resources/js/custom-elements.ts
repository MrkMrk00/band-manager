import { type ComponentType, withSolid } from 'solid-element';
import { type FunctionComponent, register, compose } from 'component-register';

export function withNoShadowDOM<T extends object>(
    baseComponent: ComponentType<T>,
): ComponentType<T> {
    return function (props, options) {
        const { element } = options;
        Object.defineProperty(element, 'renderRoot', {
            value: element,
        });

        return (baseComponent as FunctionComponent<T>)(props, options);
    };
}

export default function customElement<T extends object>(
    tag: string,
    propsOrComponent: ComponentType<T> | Record<string, any>,
    component?: ComponentType<T>,
) {
    compose(
        register(tag, typeof component === 'undefined' ? undefined : propsOrComponent),
        withSolid,
        withNoShadowDOM,
    )(component ?? (propsOrComponent as ComponentType<any>));
}
