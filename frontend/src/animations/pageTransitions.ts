import { gsap } from "gsap";

export function pageEnter(container: HTMLElement, duration = 0.6) {
  const tl = gsap.timeline();
  tl.fromTo(
    container,
    { autoAlpha: 0, y: 20 },
    { autoAlpha: 1, y: 0, duration },
  );
  return tl;
}

export function pageExit(container: HTMLElement, duration = 0.4) {
  const tl = gsap.timeline();
  tl.to(container, { autoAlpha: 0, y: -20, duration });
  return tl;
}
