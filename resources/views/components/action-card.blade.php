<div class="overflow-hidden border border-gray-200 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:-translate-y-2 cursor-pointer group card-shimmer stagger-animation animate-fade-in bg-white">
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $image }}" 
             alt="{{ $alt }}" 
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
    </div>
    <div class="p-6">
        <h3 class="text-xl font-bold text-dark mb-3 group-hover:text-primary transition-colors duration-300">
            {{ $title }}
        </h3>
        <p class="text-gray leading-relaxed">
            {{ $description }}
        </p>
    </div>
</div>
