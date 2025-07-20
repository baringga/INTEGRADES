<div class="text-center transition-all duration-300 hover:scale-105 hover:shadow-lg hover:bg-light p-6 rounded-lg cursor-pointer group stagger-animation animate-fade-in">
    <div class="w-16 h-16 bg-green rounded-full mx-auto mb-4 flex items-center justify-center transition-all duration-300 group-hover:bg-primary/10 group-hover:scale-110">
        <div class="w-12 h-12 bg-gray rounded-full transition-all duration-300 group-hover:bg-primary"></div>
    </div>
    <h4 class="font-bold text-dark mb-1 group-hover:text-primary transition-colors duration-300">
        {{ $name }}
    </h4>
    <p class="text-gray text-sm mb-4">{{ $role }}</p>
    <p class="text-gray text-sm leading-relaxed">
        "{{ $testimonial }}"
    </p>
</div>
