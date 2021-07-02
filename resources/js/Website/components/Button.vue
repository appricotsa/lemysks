<template>
    <a
        class="c-button"
        :class="[
            color
                ? outline
                    ? `c-button--outline-${color}`
                    : `c-button--${color}`
                : '',
            isLink ? `c-button--isLink-${color}` : '',
            block ? 'c-button--block' : '',
            pill ? 'c-button--pill' : '',
            width ? `c-button--${width}` : '',
            size ? `c-button--${size}` : '',
            onlyIcon ? `c-button--only-icon` : ''
        ]"
        :disabled="disabled"
        :target="target"
    >
        <SVGIcon
            v-if="icon || onlyIcon"
            :name="icon"
            :size="iconSize"
        ></SVGIcon>
        {{ onlyIcon ? null : text }}
    </a>
</template>

<script>
import SVGIcon from "../components/SVGIcon";

export default {
    components: {
        SVGIcon
    },
    props: {
        text: null,
        color: null,
        outline: Boolean,
        isLink: Boolean,
        block: Boolean,
        pill: Boolean,
        width: {
            type: String,
            validator: prop => ["sm-w", "md-w", "lg-w", "xl-w"].includes(prop),
            default: "sm-w"
        },
        size: {
            type: String,
            validator: prop => ["sm", "md", "lg"].includes(prop),
            default: "sm"
        },
        icon: String,
        iconSize: {
            type: String,
            validator: prop => ["xs", "sm", "md", "lg"].includes(prop),
            default: "md"
        },
        onlyIcon: Boolean,
        disabled: Boolean,
        target: {
            type: String,
            validator: prop => ["_blank", "_self", "_parent"].includes(prop)
        }
    }
};
</script>

<style></style>
