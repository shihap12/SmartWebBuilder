import { gsap } from "gsap";

export function runPublishAnimation(container: HTMLElement) {
  const overlay = document.createElement("div");
  overlay.style.position = "fixed";
  overlay.style.top = "0";
  overlay.style.left = "0";
  overlay.style.right = "0";
  overlay.style.bottom = "0";
  overlay.style.background = "rgba(0,0,0,0.6)";
  overlay.style.display = "flex";
  overlay.style.alignItems = "center";
  overlay.style.justifyContent = "center";
  overlay.style.zIndex = "9999";
  const card = document.createElement("div");
  card.style.background = "#fff";
  card.style.padding = "24px";
  card.style.borderRadius = "8px";
  card.textContent = "Publishing...";
  overlay.appendChild(card);
  document.body.appendChild(overlay);

  const tl = gsap.timeline({
    onComplete: () => {
      document.body.removeChild(overlay);
    },
  });
  tl.fromTo(
    card,
    { scale: 0.9, autoAlpha: 0 },
    { scale: 1, autoAlpha: 1, duration: 0.45 },
  );
  tl.to(card, { scale: 1.03, duration: 0.25, yoyo: true, repeat: 1 });
  tl.to(card, { autoAlpha: 0, scale: 0.95, duration: 0.35, delay: 0.6 });
  return tl;
}
