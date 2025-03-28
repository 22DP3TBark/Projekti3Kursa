<script setup>
// <nav>
//                 <input type="text" class="ListInput"  placeholder="Price">
//                 <input type="text" class="ListInput" placeholder="">
//                 <button class="ListButton">Search</button><h1>Propery Listings</h1>
            
        //    <p>Find your dream home</p>
           
//             </nav>

</script>

<template>
    <div class="listings-container">
        <!-- Headers -->
        <header class="header">
            <h1>Property Listings</h1>
            <div class="search">
                <input type="text" class="ListInput"  placeholder="Price">
                <input type="text" class="ListInput" placeholder="">
                <button class="ListButton">Search</button>
            </div>
        </header>

        <!-- MainContent -->

        <main class="main-content">
            <aside class="filters">
                <h2>Filters</h2>

                <!-- Filter by Price -->
                <div class="filter-group">
                    <label for="">PriceRange</label>
                    <div class="input-group">
                        <input type="text" placeholder="min price">
                        <input type="text" placeholder="Max price" >
                    </div>
                </div>

                <!-- Filter by Type -->
                <div class="filter-group">
                    <label for="">Property Type:</label>
                    <div class="checkbox-group">
                        <label for=""><input type="checkbox">House</label>
                        <label for=""><input type="checkbox">Aparment</label>
                        <label for=""><input type="checkbox"> studio</label>
                    </div>
                </div>

                <!-- Bathrooms -->
                <div class="filter-group">
                <label>Bathrooms:</label>
                <select>
                    <option value="">Any</option>
                    <option value="1">1+</option>
                    <option value="2">2+</option>
                    <option value="3">3+</option>
                </select>
                </div>

                <!-- Amenities -->
                <div class="filter-group">
                <label>Amenities:</label>
                <div class="checkbox-group">
                    <label><input type="checkbox"> Balcony</label>
                    <label><input type="checkbox"> Garage</label>
                    <label><input type="checkbox"> Swimming Pool</label>
                </div>
                </div>

                <!-- Apply Filters Button -->
                <button class="apply-filters">Apply Filters</button>
            </aside>

            <!-- Listings -->
            <section class="listings">
                <h2>Avalibale Properties</h2>
                <div class="properties-grid">
                    <div class="property-card">
                        <img  src="https://www.bhg.com/thmb/TD9qUnFen4PBLDuB2hn9yhGXPv8=/1866x0/filters:no_upscale():strip_icc()/white-house-a-frame-section-c0a4a3b3-e722202f114e4aeea4370af6dbb4312b.jpg" alt="">
                        <h3>Jurmala </h3>
                        <p>Adresse: Cinciski iela 50</p>
                        <p>Price: 200 000</p>
                        <p>Rooms: 4</p> 
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<style scoped>
@import '../assets/listings/Listings.css';
</style>