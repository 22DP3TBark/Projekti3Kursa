<script setup>
import { ref } from 'vue';

const jobs = ref([
  {
    id: 1,
    company: 'Riga',
    logo: 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg',
    title: 'Home 1 ',
    applicants: '25 Homes',
    tags: ['3 beds', '2 toilets'],
    salary: '1.2 mil',
    postedDays: 5,
    description: 'Doing the right thing for investors is what we\'re all about at Vanguard, and that in...'
  },
  {
    id: 2,
    company: 'Jurmala',
    logo: 'https://media.istockphoto.com/id/1026205392/photo/beautiful-luxury-home-exterior-at-twilight.jpg?s=612x612&w=0&k=20&c=HOCqYY0noIVxnp5uQf1MJJEVpsH_d4WtVQ6-OwVoeDo=',
    title: 'home 2',
    applicants: '14 homes',
    tags: ['8 beds ', '3toilets', '2 kitchens'],
    salary: '500.000$',
    postedDays: 3,
    description: 'Netflix is one of the world\'s leading streaming entertainment service with o...'
  },
  {
    id: 3,
    company: 'Liepaja',
    logo: 'https://www.bhg.com/thmb/TD9qUnFen4PBLDuB2hn9yhGXPv8=/1866x0/filters:no_upscale():strip_icc()/white-house-a-frame-section-c0a4a3b3-e722202f114e4aeea4370af6dbb4312b.jpg  ',
    title: 'home 3',
    applicants: '59 homes',
    tags: ['5 beds', '3 toilets', '2 kitchens'],
    salary: '750.000$',
    postedDays: 4,
    description: 'Welcome to Lightspeed LA, the first U.S.-based AAA game development studio f...'
  }
]);

const type = ref([
  { id: 'singlefamily', label: 'Single home', checked: true },
  { id: 'complex', label: 'Complex', checked: false },
  { id: 'duplex', label: 'Duplex', checked: false },
]);
</script>

<template>
    <div class="container">
        <header>
            <div class="hero">
                <h1>Find your dream home</h1>
                <div class="search-box">
                    <div class="search-input">
                        <input type="text" placeholder="Search for listings">
                    </div>
                    <div class="location-input">
                        <input type="text" placeholder="Location">
                    </div>
                    <button class="search-button">Button</button>
                </div>
            </div>
        </header>
        <main>
            <div class="content">
                <aside class="filters">
                    <h2>House types</h2>
                    <div class="Clear-all">Clear all</div>
                    <div class="filter-group">
                        <div class="filter-item">
                            <input type="checkbox" :id="type.id">
                            <label :for="type.id">{{ type.label }}</label>
                        </div>
                    </div>

                    <h2>Price range</h2>
                    <div class="salary-slider">
                        <input type="range" min="50" max="120" value="85">
                            <div class="salary-range">
                                <span>$50k</span>
                                <span>$120k</span>
                            </div>
                    </div>
                </aside>

                <section class="jobs">
          <div class="jobs-header">
            <h2>Recommended Homes</h2>
            <button class="sort-button">Most recent</button>
          </div>

                <div class="job-cards">
                    <div v-for="job in jobs" :key="job.id" class="job-card">
                    <div class="job-header">
                        <img :src="job.logo" :alt="job.company + ' logo'" class="company-logo">
                        <button class="favorite-button">♡</button>
                    </div>
                    <div class="job-content">
                        <h3>{{ job.title }}</h3>
                        <p class="company-name">{{ job.company }} • {{ job.applicants }}</p>
                        <div class="tags">
                        <span v-for="(tag, index) in job.tags" :key="index" class="tag">{{ tag }}</span>
                        </div>
                        <p class="description">{{ job.description }}</p>
                        <div class="job-footer">
                        <span class="salary">{{ job.salary }}</span>
                        <span class="posted">Posted {{ job.postedDays }} days ago</span>
                        </div>
                    </div>
                    </div>
                </div>
                </section>
            </div>
        </main>
    </div>
</template>

<style scoped>
@import '../assets/listings/Listings.css';
</style>