import { gsap } from "gsap";

export function animateElementIn(el: HTMLElement, delay = 0) {
  return gsap.fromTo(
    el,
    { autoAlpha: 0, y: 10, scale: 0.98 },
    { autoAlpha: 1, y: 0, scale: 1, duration: 0.35, delay },
  );
}

export function animateElementOut(el: HTMLElement) {
  return gsap.to(el, { autoAlpha: 0, y: -10, scale: 0.98, duration: 0.25 });
}

export function shakeElement(el: HTMLElement) {
  return gsap.fromTo(
    el,
    { x: -6 },
    { x: 6, duration: 0.05, yoyo: true, repeat: 5, clearProps: "x" },
  );
}
