<template>
    <div class="home">
        <!-- Hero -->
        <section class="hero">
            <p class="hero__text hero__text--left">
                Save the places you've always dreamed of visiting. Organize them,
                prioritize them, and watch your list turn into real adventures.
            </p>
            <router-link to="/register" class="hero__cta">START YOUR JOURNEY →</router-link>
            <p class="hero__text hero__text--right">
                Keep all the places you want to see, things you want to experience,
                and adventures you want to have in one place.
            </p>
            <h1 class="hero__brand">WANDERLIST</h1>
        </section>

        <!-- Recommended destinations -->
        <section class="recommended">
            <div class="recommended__head">
                <h2>RECOMMENDED DESTINATIONS</h2>
                <div class="recommended__arrows">
                    <button type="button" aria-label="Previous" @click="scrollCards(-1)">&lt;</button>
                    <button type="button" aria-label="Next" @click="scrollCards(1)">&gt;</button>
                </div>
            </div>

            <ul ref="track" class="cards">
                <li v-for="place in destinations" :key="place.name" class="card">
                    <div class="card__img" :style="{ backgroundImage: `url(${place.image})` }">
                        <span>{{ place.name }}</span>
                    </div>
                    <router-link to="/discover" class="card__link">EXPLORE →</router-link>
                </li>
            </ul>
        </section>

        <!-- How it works -->
        <section class="how">
            <p class="how__label">HOW IT WORKS</p>
            <div class="how__head">
                <h2>PLAN SAVE <em>REMEMBER</em></h2>
                <p>YOUR PLACES, YOUR PLANS, YOUR ADVENTURES<br>— ALL IN ONE PLACE.</p>
            </div>

            <ol class="steps">
                <li v-for="step in steps" :key="step.number" class="step">
                    <span class="step__num">{{ step.number }}</span>
                    <h3>{{ step.title }}</h3>
                    <p>{{ step.text }}</p>
                </li>
            </ol>
        </section>

        <!-- Why it matters -->
        <section class="why">
            <div class="why__img" />
            <div class="why__body">
                <p class="why__label">WHY IT MATTERS</p>
                <h2>PLACES WORTH REMEMBERING</h2>
                <p class="why__text">
                    FROM HIDDEN MOUNTAIN LAKES TO CITIES YOU'VE ALWAYS WANTED TO SEE —
                    KEEP EVERY DESTINATION THAT INSPIRES YOU IN ONE PLACE.
                </p>
                <router-link to="/discover" class="why__link">EXPLORE DESTINATIONS →</router-link>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            
            destinations: [
                { name: 'SELLA PASS | ITALY', image: '/images/dest-italy.jpg' },
                { name: 'ISLANDS | NORWAY', image: '/images/dest-norway.jpg' },
                { name: 'FJORDS | ICELAND', image: '/images/dest-iceland.jpg' },
                { name: 'ISLAND | PORTUGAL', image: '/images/dest-portugal.jpg' }
            ],

            steps: [
                {
                    number: '01',
                    title: 'PLAN',
                    text: 'CREATE YOUR PERSONAL LIST OF DREAM DESTINATIONS, FROM FAMOUS FJORDS TO THE TRAIL NOBODY\'S HEARD OF YET.'
                },
                {
                    number: '02',
                    title: 'SAVE',
                    text: 'SET A BUDGET AND PRIORITY FOR EVERY PLACE, SO YOU ALWAYS KNOW WHAT YOU\'RE SAVING FOR NEXT.'
                },
                {
                    number: '03',
                    title: 'REMEMBER',
                    text: 'MARK THE PLACES YOU\'VE VISITED AND KEEP YOUR TRAVEL MEMORIES ORGANIZED, ONE TRIP AT A TIME.'
                }
            ]
        }
    },

    methods: {
        scrollCards(direction) {
            const track = this.$refs.track
            track.scrollBy({ left: direction * track.clientWidth * 0.8, behavior: 'smooth' })
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

.home {
    --olive: #7c8a5c;
    --link: #90BCE3;
    --serif: 'Italiana', serif;

    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
    color: #000;
    background: #fff;
}

.home h1,
.home h2,
.home h3 {
    margin: 0;
    font-family: var(--serif);
    font-weight: 400;
}

.home a {
    color: inherit;
    text-decoration: none;
}

.home a:focus-visible,
.home button:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}


.hero {
    position: relative;
    height: calc(100vh - 4.5rem);   
    min-height: 26rem;
    margin: 0 0.6rem;
    border-radius: 1.2rem;
    overflow: hidden;
    color: #fff;
    background: url('/image/hero.png') center / cover no-repeat;
}

.hero__text {
    position: absolute;
    margin: 0;
    max-width: 21rem;
    font-size: 0.95rem;
    line-height: 1.35;
    text-shadow: 0 1px 8px rgba(0, 0, 0, 0.35);
}

.hero__text--left {
    top: 40%;
    left: 1.5rem;
}

.hero__text--right {
    top: 61%;
    right: 3rem;
}

.hero__cta {
    position: absolute;
    top: 40%;
    left: 36%;
    font-family: var(--serif);
    font-size: 1.5rem;
    text-shadow: 0 1px 8px rgba(0, 0, 0, 0.35);
}

.hero__brand {
    position: absolute;
    left: 1.5rem;
    bottom: -0.5rem;
    font-size: clamp(4rem, 15vw, 14rem);
    line-height: 1;
    letter-spacing: 0.01em;
}


.recommended {
    padding: 4rem 0.6rem 0;
}

.recommended__head {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.5rem;
    margin: 0 1.5rem 2.5rem 0;
}

.recommended__head h2 {
    font-size: clamp(1.4rem, 2.4vw, 2rem);
    letter-spacing: 0.06em;
}

.recommended__arrows button {
    border: 0;
    background: none;
    font: inherit;
    font-size: 1.5rem;
    cursor: pointer;
}

.cards {
    display: grid;
    grid-auto-flow: column;
    grid-auto-columns: calc((100% - 3 * 2.2rem) / 4);
    gap: 2.2rem;
    margin: 0;
    padding: 0;
    list-style: none;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
}

.cards::-webkit-scrollbar {
    display: none;
}

.card {
    scroll-snap-align: start;
}

.card__img {
    display: flex;
    align-items: flex-end;
    aspect-ratio: 1.3 / 1;
    padding: 0.4rem 0.5rem;
    border-radius: 1rem;
    background: #6b7a63 center / cover no-repeat;
    color: #fff;
    font-family: var(--serif);
    font-size: clamp(1.1rem, 1.9vw, 1.7rem);
    letter-spacing: 0.03em;
    text-shadow: 0 1px 10px rgba(0, 0, 0, 0.5);
}

.card__link {
    display: inline-block;
    margin: 0.7rem 0 0 0.3rem;
    font-size: 0.7rem;
}


.how {
    max-width: 68rem;
    margin: 8rem auto 0;   
    padding: 0 1.5rem;
}

.how__label {
    margin: 0 0 1rem;
    font-family: var(--serif);
    font-size: 1.1rem;
    color: var(--olive);
}

.how__head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #5f5f5f;
}

.how__head h2 {
    font-size: clamp(2.2rem, 5vw, 4rem);
    letter-spacing: 0.04em;
    
}

.how__head em {
    font-style: normal;
    color: var(--olive);
}

.how__head p {
    margin: 0;
    max-width: 16rem;
    font-size: 0.7rem;
    text-align: right;
      align-self: flex-start;  
    margin-top: 2rem;  
}

.steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    margin: 7rem 0 0;
    padding: 0;
    list-style: none;
}

.step {
     min-height: 16rem;        
    padding: 1.5rem 2rem 0;
    text-align: center;
}

.step + .step {
    border-left: 1px solid #ccc;
}

.step__num {
    display: block;
    font-family: var(--serif);
    font-size: 1.3rem;
    color: var(--olive);
}

.step h3 {
    display: inline-block;
    margin: 0.2rem 0 1.8rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #000;
    font-size: 1.6rem;
    letter-spacing: 0.04em;
}

.step p {
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.5;
}


.why {
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    margin-top: 10rem; 
}

.why__img {
    min-height: 46rem;
    height: 100%;
    background: #7c8a5c url('/image/image 10.png') center / cover no-repeat;
}

.why__body {
    max-width: 30rem;
    padding: 4rem 2rem;
    margin: 0 auto;
}

.why__label {
    margin: 0 0 4rem;
    font-size: 0.9rem;
    font-weight: 400;
}

.why__body h2 {
    font-size: clamp(2.2rem, 4.2vw, 3.6rem);
    line-height: 1.1;
    letter-spacing: 0.03em;
}

.why__text {
    margin: 2.5rem 0 4rem;
    font-size: 1.1rem;
    line-height: 1.5;
    font-weight: 400;
}

.why__link {
    padding-bottom: 0.3rem;
    border-bottom: 1px solid var(--link);
    color: var(--link) !important;
    font-size: 0.95rem;
}

/* ---------- Mobile ---------- */
@media (max-width: 860px) {
    .hero__text--left { top: 38%; }
    .hero__text--right { top: 62%; left: 1.5rem; right: auto; }
    .hero__cta { top: 30%; left: 1.5rem; }

    .cards {
        grid-auto-columns: 70%;
        gap: 1rem;
    }

    .how__head {
        flex-direction: column;
        align-items: flex-start;
    }

    .how__head p { text-align: left; }

    .steps { grid-template-columns: 1fr; gap: 3rem; }
    .step + .step { border-left: 0; }

    .why { grid-template-columns: 1fr; margin-top: 4rem; }
    .why__img { min-height: 24rem; }
}
</style>