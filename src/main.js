import './style.css';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

const initSectionSliders = () => {
  const sliders = document.querySelectorAll('.section-slider.swiper');

  sliders.forEach(slider => {
    const track = slider.querySelector('.slider-track');
    const slides = Array.from(slider.querySelectorAll('.slide'));
    const prevBtn = slider.querySelector('.slider-control.prev');
    const nextBtn = slider.querySelector('.slider-control.next');

    if (!track || slides.length <= 1) return;

    new Swiper(slider, {
      slidesPerView: 1,
      spaceBetween: 0,
      grabCursor: true,
      loop: true,
      navigation: {
        nextEl: nextBtn,
        prevEl: prevBtn,
      },
      pagination: {
        el: slider.querySelector('.swiper-pagination'),
        clickable: true,
      },
    });
  });
};

const initMenuNavigation = (sectionTriggers) => {
  const menuLinks = document.querySelectorAll('.menu-link[data-section]');
  const navSections = Array.from(menuLinks)
    .map(link => document.getElementById(link.dataset.section))
    .filter(Boolean);

  if (!menuLinks.length || !navSections.length) {
    return;
  }

  const setActiveLink = (sectionId) => {
    menuLinks.forEach(link => {
      link.classList.toggle('active', link.dataset.section === sectionId);
    });
  };

  const getSectionById = (sectionId) => navSections.find(section => section.id === sectionId);

  const getActiveSectionId = () => {
    const offset = Math.max(140, Math.floor(window.innerHeight * 0.28));
    let activeSectionId = navSections[0].id;

    navSections.forEach(section => {
      const rect = section.getBoundingClientRect();
      if (rect.top <= offset) {
        activeSectionId = section.id;
      }
    });

    return activeSectionId;
  };

  let isScrollingToSection = false;
  let scrollTicking = false;

  const updateActiveLink = () => {
    if (!isScrollingToSection) {
      const nextActiveId = getActiveSectionId();
      setActiveLink(nextActiveId);
    }
    scrollTicking = false;
  };

  const syncActiveFromHash = () => {
    const hashSectionId = window.location.hash.replace('#', '');
    const section = getSectionById(hashSectionId);

    if (section) {
      setActiveLink(section.id);
    } else {
      updateActiveLink();
    }
  };

  menuLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      const section = getSectionById(this.dataset.section);
      if (!section) return;

      e.preventDefault();
      window.history.pushState(null, '', `#${section.id}`);
      setActiveLink(section.id);
      isScrollingToSection = true;

      const trigger = sectionTriggers[section.id];
      const scrollTarget = trigger
        ? trigger.start
        : section.offsetTop - (window.innerWidth >= 768 ? window.innerHeight * 0.25 : 137);

      gsap.to(window, {
        duration: 0.8,
        scrollTo: { y: scrollTarget, autoKill: false },
        ease: 'power2.inOut',
        onComplete: () => {
          setActiveLink(section.id);
          isScrollingToSection = false;
        }
      });
    });
  });

  const onScroll = () => {
    if (scrollTicking) return;
    scrollTicking = true;
    window.requestAnimationFrame(updateActiveLink);
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);
  window.addEventListener('hashchange', syncActiveFromHash);
  updateActiveLink();
};

const initEventModals = () => {
  const modal = document.getElementById('events-modal');
  const viewEventsBtns = document.querySelectorAll('.view-events-trigger');
  const closeModalBtn = document.getElementById('close-modal');
  const resModal = document.getElementById('reservation-modal');
  const closeResBtn = document.getElementById('close-reservation');
  const resEventName = document.getElementById('res-event-name');
  const resEventDate = document.getElementById('res-event-date');
  const resEventSpots = document.getElementById('res-event-spots');
  const resPeopleInput = document.querySelector('#reservation-form input[name="people"]');
  const reserveBtns = document.querySelectorAll('.reserve-btn');
  const reservationForm = document.getElementById('reservation-form');
  const successModal = document.getElementById('success-modal');
  const closeSuccessBtn = document.getElementById('close-success');
  const backToMainBtn = document.getElementById('back-to-main');

  viewEventsBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (modal) {
        modal.classList.remove('opacity-0', 'pointer-events-none');
      }
    });
  });

  if (closeModalBtn) {
    closeModalBtn.addEventListener('click', () => {
      modal.classList.add('opacity-0', 'pointer-events-none');
    });
  }

  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.add('opacity-0', 'pointer-events-none');
      }
    });
  }

  const clampPeopleValue = () => {
    if (!resPeopleInput) return;

    const minValue = parseInt(resPeopleInput.min || '1', 10) || 1;
    const maxValue = parseInt(resPeopleInput.max || '1', 10) || minValue;
    let currentValue = parseInt(resPeopleInput.value || String(minValue), 10);

    if (!Number.isFinite(currentValue)) {
      currentValue = minValue;
    }

    resPeopleInput.value = String(Math.min(Math.max(currentValue, minValue), maxValue));
  };

  reserveBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const name = btn.getAttribute('data-name') || 'Name of event';
      const date = btn.getAttribute('data-date') || '24/03/2026';
      const spotsText = btn.getAttribute('data-spots');

      if (resEventName) {
        resEventName.textContent = name;
      }
      if (resEventDate) {
        resEventDate.textContent = date;
      }

      if (spotsText && resEventSpots) {
        resEventSpots.textContent = spotsText;
        resEventSpots.classList.remove('hidden');

        const availableMatch = spotsText.match(/(\d+)/);
        const availableSpots = availableMatch ? parseInt(availableMatch[1], 10) : 1;
        const maxSpots = Number.isFinite(availableSpots) && availableSpots > 0 ? availableSpots : 1;

        if (resPeopleInput) {
          resPeopleInput.max = String(maxSpots);
          resPeopleInput.value = '1';
        }
      } else if (resEventSpots) {
        resEventSpots.classList.add('hidden');
        if (resPeopleInput) {
          resPeopleInput.max = '1';
          resPeopleInput.value = '1';
        }
      }

      if (resModal) {
        resModal.classList.remove('opacity-0', 'pointer-events-none');
      }
    });
  });

  if (closeResBtn) {
    closeResBtn.addEventListener('click', () => {
      if (resModal) {
        resModal.classList.add('opacity-0', 'pointer-events-none');
      }
    });
  }

  if (resModal) {
    resModal.addEventListener('click', (e) => {
      if (e.target === resModal) {
        resModal.classList.add('opacity-0', 'pointer-events-none');
      }
    });
  }

  if (resPeopleInput) {
    resPeopleInput.addEventListener('input', clampPeopleValue);
    resPeopleInput.addEventListener('change', clampPeopleValue);
  }

  if (reservationForm) {
    reservationForm.addEventListener('submit', (e) => {
      e.preventDefault();

      if (modal) {
        modal.classList.add('opacity-0', 'pointer-events-none');
      }
      if (resModal) {
        resModal.classList.add('opacity-0', 'pointer-events-none');
      }
      if (successModal) {
        successModal.classList.remove('opacity-0', 'pointer-events-none');
      }
      reservationForm.reset();
    });
  }

  const closeSuccess = () => {
    if (successModal) {
      successModal.classList.add('opacity-0', 'pointer-events-none');
    }
  };

  if (closeSuccessBtn) {
    closeSuccessBtn.addEventListener('click', closeSuccess);
  }
  if (backToMainBtn) {
    backToMainBtn.addEventListener('click', closeSuccess);
  }

  if (successModal) {
    successModal.addEventListener('click', (e) => {
      if (e.target === successModal) {
        closeSuccess();
      }
    });
  }
};

const initShowMore = () => {
  const showMoreBtns = document.querySelectorAll('.show-more');

  showMoreBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const desc = this.previousElementSibling;
      const isExpanded = desc && !desc.classList.contains('line-clamp-2');

      if (!desc) return;

      if (isExpanded) {
        desc.classList.add('line-clamp-2');
        this.querySelector('span').textContent = 'Show more';
        this.querySelector('svg').classList.add('rotate-180');
      } else {
        const parentList = this.closest('.event-list');
        if (parentList) {
          parentList.querySelectorAll('.description-short').forEach(d => {
            d.classList.add('line-clamp-2');
          });
          parentList.querySelectorAll('.show-more').forEach(b => {
            b.querySelector('span').textContent = 'Show more';
            b.querySelector('svg').classList.add('rotate-180');
          });
        }

        desc.classList.remove('line-clamp-2');
        this.querySelector('span').textContent = 'Show less';
        this.querySelector('svg').classList.remove('rotate-180');
      }
    });
  });
};

const initMapLazyLoad = () => {
  const mapContainer = document.getElementById('map-container');
  const mapPlaceholder = document.getElementById('map-placeholder');
  const mapContent = document.getElementById('map-content');
  const mapImage = document.getElementById('map-image');
  const mapTemplate = document.getElementById('map-iframe-template');

  if (!mapContainer || !mapPlaceholder) return;

  const hasMapImage = mapImage && mapImage.src;

  const observerOptions = {
    root: null,
    rootMargin: '0px 0px 800px 0px',
    threshold: 0
  };

  const loadMap = () => {
    if (mapContainer.dataset.mapLoaded === 'true') return;

    mapContainer.dataset.mapLoaded = 'true';

    if (mapPlaceholder) {
      mapPlaceholder.style.display = 'flex';
    }

    if (mapTemplate) {
      setTimeout(() => {
        const content = mapTemplate.content.cloneNode(true);
        const iframe = content.querySelector('iframe');

        if (iframe) {
          mapContent.innerHTML = '';
          mapContent.appendChild(iframe);
          mapContent.classList.remove('hidden');

          iframe.onload = () => {
            if (mapPlaceholder) {
              mapPlaceholder.style.display = 'none';
            }
          };
        } else {
          mapContent.classList.remove('hidden');
          if (mapPlaceholder) {
            mapPlaceholder.style.display = 'none';
          }
        }
      }, 100);
    }

    if (hasMapImage && mapImage) {
      setTimeout(() => {
        const img = new Image();
        img.src = mapImage.src;
        img.onload = () => {
          mapImage.classList.remove('hidden');
          if (mapPlaceholder) {
            mapPlaceholder.style.display = 'none';
          }
        };
        img.onerror = () => {
          if (mapPlaceholder) {
            mapPlaceholder.style.display = 'none';
          }
        };
      }, 100);
    }
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        loadMap();
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  observer.observe(mapContainer);
};

const initApp = () => {
  const sectionTriggers = {};
  const isDesktop = window.innerWidth >= 768;

  if (isDesktop) {
    const sections = document.querySelectorAll('section');

    sections.forEach(section => {
      const st = ScrollTrigger.create({
        trigger: section,
        start: 'bottom bottom',
        end: 'bottom 25vh',
        pin: true,
        pinSpacing: false,
        markers: false
      });

      if (section.id) {
        sectionTriggers[section.id] = st;
      }
    });
  }

  initEventModals();
  initSectionSliders();
  initMenuNavigation(sectionTriggers);
  initShowMore();
  initMapLazyLoad();
};

document.addEventListener('DOMContentLoaded', initApp);
