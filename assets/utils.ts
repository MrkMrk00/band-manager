import { register, compose, type ComponentType, type FunctionComponent, type ComponentOptions, PropsDefinitionInput } from 'component-register';
import { withSolid } from 'solid-element';

const withNoShadowDOM = <T extends object>(component: ComponentType<T>) => {
	return (props: T, options: ComponentOptions) => {
		const { element } = options;
		Object.defineProperty(element, 'renderRoot', {
			value: element
		});

		return (component as FunctionComponent<T>)(props, options);
	}
}

export function customElement<T extends object>(name: string, props: PropsDefinitionInput<T>, component: ComponentType<T>) {
	compose(
		register(name, props),
		withNoShadowDOM,
		withSolid,
	)(component);
}

