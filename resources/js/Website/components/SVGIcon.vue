<template>
    <svg
        class="c-icon__svg"
        :class="[size ? `c-icon--${size}` : '', fill ? `c-icon--${fill}` : '']"
    >
        <use :xlink:href="`${svgPath.default}#${name}`"></use>
    </svg>
</template>

<script>
export default {
    props: {
        size: {
            type: String,
            validator: prop => ["xs", "sm", "md", "xxl"].includes(prop),
            default: "md"
        },
        fill: null,
        name: null
    },
    data() {
        return {
            svgPath: require("../src/images/sprite.svg")
        };
    }
};
</script>

<style></style>
