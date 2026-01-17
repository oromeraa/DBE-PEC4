# Manual Paso a Paso - PEC4 Gestor de Museos con Laravel

Este manual detalla todos los pasos necesarios para completar la PEC4 desde cero.

---

## Requisitos Previos

- DDEV instalado y funcionando
- Git configurado
- Directorio de trabajo limpio

---

## Actividad 1. Instalación de Laravel (0,5 puntos)

### Paso 1.1 - Crear directorio del proyecto
```bash
mkdir DBE-PEC4
cd DBE-PEC4
```

### Paso 1.2 - Configurar DDEV para Laravel
```bash
ddev config --project-type=laravel --docroot=public --php-version=8.2 --database=mysql:8.0
```

### Paso 1.3 - Instalar Laravel 12
```bash
ddev composer create "laravel/laravel:^12" . --prefer-dist
```

> **Nota:** Si hay archivos en el directorio, muévelos temporalmente antes de ejecutar este comando.

### Paso 1.4 - Verificar instalación
```bash
ddev describe
```

Deberías ver una tabla con la URL de acceso (ej: `https://dbe-pec4.ddev.site`).

### Paso 1.5 - Ejecutar migraciones iniciales en MySQL
```bash
ddev php artisan migrate:fresh
```

### Verificación
Abre `https://dbe-pec4.ddev.site` en el navegador y verifica que aparece la página de bienvenida de Laravel.

---

## Actividad 2. Sistema de Autenticación (1 punto)

### Paso 2.1 - Instalar Laravel Breeze
```bash
ddev composer require laravel/breeze --dev
```

### Paso 2.2 - Configurar Breeze con Blade
```bash
ddev php artisan breeze:install blade
```

Esto instalará automáticamente las dependencias de Node y compilará los assets.

### Paso 2.3 - Ejecutar migraciones
```bash
ddev php artisan migrate
```

### Paso 2.4 - Modificar mensaje de bienvenida

Editar `resources/views/dashboard.blade.php` y cambiar la línea:
```blade
{{ __("You're logged in!") }}
```
Por:
```blade
Nos alegramos de volverte a ver, {{ Auth::user()->name }}!
```

### Paso 2.5 - Registrar usuario de prueba

1. Acceder a `https://dbe-pec4.ddev.site/register`
2. Crear usuario con:
   - **Name**: admin
   - **Email**: admin@fakemail.com
   - **Password**: uoc-25-S1@

### Verificación
- Cerrar sesión (Log Out)
- Iniciar sesión con las credenciales
- Verificar que aparece "Nos alegramos de volverte a ver, admin!"

---

## Actividad 3. Migraciones, Modelos y Tinker (1,5 puntos)

### Paso 3.1 - Crear modelo Topic con migración
```bash
ddev php artisan make:model Topic -m
```

### Paso 3.2 - Crear modelo Museum con migración
```bash
ddev php artisan make:model Museum -m
```

### Paso 3.3 - Crear migración para tabla pivot
```bash
ddev php artisan make:migration create_museum_topic_table
```

### Paso 3.4 - Editar migración de topics

Archivo: `database/migrations/xxxx_create_topics_table.php`

```php
public function up(): void
{
    Schema::create('topics', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 255);
        $table->timestamps();
    });
}
```

### Paso 3.5 - Editar migración de museums

Archivo: `database/migrations/xxxx_create_museums_table.php`

```php
public function up(): void
{
    Schema::create('museums', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 255);
        $table->string('ciudad');
        $table->text('fechas_horarios');
        $table->enum('visitas_guiadas', ['si', 'no']);
        $table->decimal('precio', 8, 2);
        $table->string('imagen_portada');
        $table->timestamps();
    });
}
```

### Paso 3.6 - Editar migración de tabla pivot

Archivo: `database/migrations/xxxx_create_museum_topic_table.php`

```php
public function up(): void
{
    Schema::create('museum_topic', function (Blueprint $table) {
        $table->foreignId('museum_id')->constrained()->onDelete('cascade');
        $table->foreignId('topic_id')->constrained()->onDelete('cascade');
        $table->primary(['museum_id', 'topic_id']);
    });
}
```

### Paso 3.7 - Editar modelo Topic

Archivo: `app/Models/Topic.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['nombre'];

    public function museums()
    {
        return $this->belongsToMany(Museum::class);
    }
}
```

### Paso 3.8 - Editar modelo Museum

Archivo: `app/Models/Museum.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Museum extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'ciudad',
        'fechas_horarios',
        'visitas_guiadas',
        'precio',
        'imagen_portada',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }
}
```

### Paso 3.9 - Ejecutar migraciones
```bash
ddev php artisan migrate
```

### Paso 3.10 - Crear museos reales con Tinker
```bash
ddev php artisan tinker
```

En Tinker, ejecutar:
```php
// Crear temáticas
$t1 = App\Models\Topic::create(['nombre' => 'Arte Contemporáneo']);
$t2 = App\Models\Topic::create(['nombre' => 'Arquitectura']);
$t3 = App\Models\Topic::create(['nombre' => 'Ciencia']);
$t4 = App\Models\Topic::create(['nombre' => 'Historia Natural']);

// Crear Guggenheim
$g = App\Models\Museum::create([
    'nombre' => 'Museo Guggenheim Bilbao',
    'ciudad' => 'Bilbao',
    'fechas_horarios' => 'Martes a Domingo: 10:00 - 20:00',
    'visitas_guiadas' => 'si',
    'precio' => 16.00,
    'imagen_portada' => 'museums/guggenheim.jpg'
]);
$g->topics()->attach([1, 2]);

// Crear CosmoCaixa
$c = App\Models\Museum::create([
    'nombre' => 'CosmoCaixa Barcelona',
    'ciudad' => 'Barcelona',
    'fechas_horarios' => 'Todos los días: 10:00 - 20:00',
    'visitas_guiadas' => 'si',
    'precio' => 6.00,
    'imagen_portada' => 'museums/cosmocaixa.jpg'
]);
$c->topics()->attach([3, 4]);

exit
```

---

## Actividad 4. Generar Contenidos Ficticios (1,5 puntos)

### Paso 4.1 - Crear storage link
```bash
ddev php artisan storage:link
mkdir -p storage/app/public/museums
```

### Paso 4.2 - Crear Factory para Museum
```bash
ddev php artisan make:factory MuseumFactory --model=Museum
```

### Paso 4.3 - Editar MuseumFactory

Archivo: `database/factories/MuseumFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MuseumFactory extends Factory
{
    public function definition(): array
    {
        static $imageIndex = 1;
        
        $horarios = [
            'Lunes a Viernes: 9:00 - 17:00',
            'Martes a Domingo: 10:00 - 18:00',
            'Todos los días: 10:00 - 20:00',
            'Lunes a Sábado: 9:30 - 19:30',
            'Miércoles a Lunes: 11:00 - 19:00',
        ];

        return [
            'nombre' => 'Museo ' . fake()->unique()->company(),
            'ciudad' => fake()->city(),
            'fechas_horarios' => fake()->randomElement($horarios),
            'visitas_guiadas' => fake()->randomElement(['si', 'no']),
            'precio' => fake()->randomFloat(2, 0, 25),
            'imagen_portada' => 'museums/museo_' . ($imageIndex++) . '.jpg',
        ];
    }
}
```

### Paso 4.4 - Crear TopicSeeder

Archivo: `database/seeders/TopicSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            'Arte Contemporáneo',
            'Arquitectura',
            'Ciencia',
            'Historia Natural',
        ];

        foreach ($topics as $topic) {
            Topic::create(['nombre' => $topic]);
        }
    }
}
```

### Paso 4.5 - Crear RealMuseumSeeder

Archivo: `database/seeders/RealMuseumSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Museum;

class RealMuseumSeeder extends Seeder
{
    public function run(): void
    {
        $guggenheim = Museum::create([
            'nombre' => 'Museo Guggenheim Bilbao',
            'ciudad' => 'Bilbao',
            'fechas_horarios' => 'Martes a Domingo: 10:00 - 20:00. Lunes cerrado.',
            'visitas_guiadas' => 'si',
            'precio' => 16.00,
            'imagen_portada' => 'museums/guggenheim.jpg',
        ]);
        $guggenheim->topics()->attach([1, 2]);

        $cosmocaixa = Museum::create([
            'nombre' => 'CosmoCaixa Barcelona',
            'ciudad' => 'Barcelona',
            'fechas_horarios' => 'Todos los días: 10:00 - 20:00.',
            'visitas_guiadas' => 'si',
            'precio' => 6.00,
            'imagen_portada' => 'museums/cosmocaixa.jpg',
        ]);
        $cosmocaixa->topics()->attach([3, 4]);
    }
}
```

### Paso 4.6 - Crear MuseumSeeder

Archivo: `database/seeders/MuseumSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Museum;
use App\Models\Topic;

class MuseumSeeder extends Seeder
{
    public function run(): void
    {
        $museums = Museum::factory()->count(40)->create();
        $topicIds = Topic::pluck('id')->toArray();

        $museums->each(function ($museum, $index) use ($topicIds) {
            $numTopics = $index < 20 ? rand(2, 3) : rand(1, 2);
            $assignedTopics = array_rand(array_flip($topicIds), min($numTopics, count($topicIds)));
            if (!is_array($assignedTopics)) {
                $assignedTopics = [$assignedTopics];
            }
            $museum->topics()->attach($assignedTopics);
        });
    }
}
```

### Paso 4.7 - Editar DatabaseSeeder

Archivo: `database/seeders/DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TopicSeeder::class);
        $this->call(RealMuseumSeeder::class);
        $this->call(MuseumSeeder::class);
    }
}
```

### Paso 4.8 - Ejecutar seeders
```bash
ddev php artisan migrate:fresh --seed
```

### Verificación
```bash
ddev php artisan tinker --execute="echo 'Museums: ' . App\Models\Museum::count() . ', Topics: ' . App\Models\Topic::count();"
```

Debería mostrar: `Museums: 42, Topics: 4`

---

## Actividad 5. Implementar Frontend (2 puntos)

### Paso 5.1 - Crear MuseumController
```bash
ddev php artisan make:controller MuseumController
```

### Paso 5.2 - Editar MuseumController

Archivo: `app/Http/Controllers/MuseumController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Museum;

class MuseumController extends Controller
{
    public function index()
    {
        $fixedMuseums = Museum::whereIn('id', [1, 2])->get();
        $randomMuseums = Museum::whereNotIn('id', [1, 2])
            ->inRandomOrder()
            ->limit(3)
            ->get();
        $museums = $fixedMuseums->merge($randomMuseums);
        
        return view('museums.home', compact('museums'));
    }

    public function show($id)
    {
        $museum = Museum::with('topics')->findOrFail($id);
        return view('museums.show', compact('museum'));
    }
}
```

### Paso 5.3 - Editar rutas web

Archivo: `routes/web.php`

Añadir al inicio:
```php
use App\Http\Controllers\MuseumController;
```

Cambiar la ruta raíz y añadir la de museo:
```php
Route::get('/', [MuseumController::class, 'index'])->name('home');
Route::get('/museum/{id}', [MuseumController::class, 'show'])->name('museum.show');
```

### Paso 5.4 - Crear directorio de vistas
```bash
mkdir -p resources/views/museums
```

### Paso 5.5 - Crear vista home

Archivo: `resources/views/museums/home.blade.php`

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestor de Museos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-6">Museos Destacados</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($museums as $museum)
                            <div class="bg-gray-50 rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow">
                                <img 
                                    src="{{ asset('storage/' . $museum->imagen_portada) }}" 
                                    alt="{{ $museum->nombre }}"
                                    class="w-full h-48 object-cover"
                                    onerror="this.src='https://via.placeholder.com/400x200?text=Museo'"
                                >
                                <div class="p-4">
                                    <a href="{{ route('museum.show', $museum->id) }}" 
                                       class="text-lg font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                        {{ $museum->nombre }}
                                    </a>
                                    <p class="text-gray-600 mt-1">
                                        <span class="font-medium">Ciudad:</span> {{ $museum->ciudad }}
                                    </p>
                                    <p class="text-gray-800 mt-2 font-bold">
                                        {{ number_format($museum->precio, 2) }} €
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

### Paso 5.6 - Crear vista show

Archivo: `resources/views/museums/show.blade.php`

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $museum->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <img 
                            src="{{ asset('storage/' . $museum->imagen_portada) }}" 
                            alt="{{ $museum->nombre }}"
                            class="w-full h-64 md:h-full object-cover"
                            onerror="this.src='https://via.placeholder.com/600x400?text=Museo'"
                        >
                    </div>
                    
                    <div class="md:w-1/2 p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $museum->nombre }}</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="font-semibold text-gray-700">Ciudad:</span>
                                <span class="text-gray-600">{{ $museum->ciudad }}</span>
                            </div>
                            
                            <div>
                                <span class="font-semibold text-gray-700">Horarios:</span>
                                <p class="text-gray-600">{{ $museum->fechas_horarios }}</p>
                            </div>
                            
                            <div>
                                <span class="font-semibold text-gray-700">Visitas guiadas:</span>
                                <span class="text-gray-600 capitalize">{{ $museum->visitas_guiadas }}</span>
                            </div>
                            
                            <div>
                                <span class="font-semibold text-gray-700">Precio:</span>
                                <span class="text-2xl font-bold text-green-600">{{ number_format($museum->precio, 2) }} €</span>
                            </div>
                            
                            <div>
                                <span class="font-semibold text-gray-700">Temáticas:</span>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @forelse($museum->topics as $topic)
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                            {{ $topic->nombre }}
                                        </span>
                                    @empty
                                        <span class="text-gray-500">Sin temáticas asignadas</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('home') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                ← Volver al inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

### Paso 5.7 - Modificar navigation.blade.php

Archivo: `resources/views/layouts/navigation.blade.php`

Añadir en la sección de Navigation Links (después del dashboard):
```blade
<x-nav-link :href="route('home')" :active="request()->routeIs('home')">
    Home
</x-nav-link>

<x-nav-link href="{{ url('/api/museums/1') }}" target="_blank">
    API_museums
</x-nav-link>
<x-nav-link href="{{ url('/api/museum/1') }}" target="_blank">
    API_museum
</x-nav-link>
<x-nav-link href="{{ url('/api/topic/1/1') }}" target="_blank">
    API_topic
</x-nav-link>
```

También añadir condicionales `@auth` / `@guest` para mostrar Login/Register a invitados.

---

## Actividad 6. API (2 puntos)

### Paso 6.1 - Instalar API scaffolding
```bash
ddev php artisan install:api --without-migration-prompt
```

### Paso 6.2 - Crear ApiController
```bash
ddev php artisan make:controller Api/ApiController
```

### Paso 6.3 - Editar ApiController

Archivo: `app/Http/Controllers/Api/ApiController.php`

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Museum;
use App\Models\Topic;

class ApiController extends Controller
{
    const PER_PAGE = 5;

    public function museums($page)
    {
        $page = (int) $page;
        $total = Museum::count();
        $totalPages = ceil($total / self::PER_PAGE);
        
        if ($page < 1 || ($totalPages > 0 && $page > $totalPages)) {
            return response()->json(['error' => 'Página no encontrada'], 404);
        }

        $museums = Museum::with('topics')
            ->skip(($page - 1) * self::PER_PAGE)
            ->take(self::PER_PAGE)
            ->get();

        return response()->json([
            'page' => $page,
            'total_pages' => $totalPages,
            'total_museums' => $total,
            'data' => $museums
        ]);
    }

    public function museum($id)
    {
        $museum = Museum::with('topics')->find($id);
        
        if (!$museum) {
            return response()->json(['error' => 'Museo no encontrado'], 404);
        }

        return response()->json($museum);
    }

    public function topic($id, $page)
    {
        $topic = Topic::find($id);
        
        if (!$topic) {
            return response()->json(['error' => 'Temática no encontrada'], 404);
        }

        $page = (int) $page;
        $total = $topic->museums()->count();
        $totalPages = max(1, ceil($total / self::PER_PAGE));
        
        if ($page < 1 || $page > $totalPages) {
            return response()->json(['error' => 'Página no encontrada'], 404);
        }

        $museums = $topic->museums()
            ->skip(($page - 1) * self::PER_PAGE)
            ->take(self::PER_PAGE)
            ->get(['id', 'nombre', 'ciudad']);

        return response()->json([
            'topic' => $topic->nombre,
            'page' => $page,
            'total_pages' => $totalPages,
            'total_museums' => $total,
            'data' => $museums
        ]);
    }
}
```

### Paso 6.4 - Configurar rutas API

Archivo: `routes/api.php`

Añadir:
```php
use App\Http\Controllers\Api\ApiController;

Route::get('/museums/{page}', [ApiController::class, 'museums']);
Route::get('/museum/{id}', [ApiController::class, 'museum']);
Route::get('/topic/{id}/{page}', [ApiController::class, 'topic']);
```

### Verificación de APIs
```bash
# Probar listado paginado
curl https://dbe-pec4.ddev.site/api/museums/1

# Probar museo individual
curl https://dbe-pec4.ddev.site/api/museum/1

# Probar por temática
curl https://dbe-pec4.ddev.site/api/topic/1/1

# Probar error 404
curl https://dbe-pec4.ddev.site/api/museum/999
```

---

## Actividad 7. Publicación (1 punto)

### Pasos para publicar en servidor remoto:

1. Exportar base de datos:
```bash
ddev export-db --file=db_backup.sql.gz
```

2. Subir archivos por FTP/SFTP al servidor

3. En el servidor remoto:
   - Descomprimir archivos
   - Importar base de datos
   - Configurar `.env` con credenciales del servidor
   - Ejecutar `php artisan config:cache`
   - Verificar permisos de `storage/` y `bootstrap/cache/`

---

## Actividad 8. Comparativa (0,5 puntos)

Debes comentar basándote en tu experiencia personal con:
- **Drupal (PEC2)**: Ventajas e inconvenientes encontrados
- **PHP puro (PEC3)**: Ventajas e inconvenientes encontrados
- **Laravel (PEC4)**: Ventajas e inconvenientes encontrados

---

## Resumen de Comandos Principales

```bash
# Configuración inicial
ddev config --project-type=laravel --docroot=public --php-version=8.2 --database=mysql:8.0
ddev composer create "laravel/laravel:^12" . --prefer-dist

# Breeze
ddev composer require laravel/breeze --dev
ddev php artisan breeze:install blade

# Modelos y migraciones
ddev php artisan make:model Topic -m
ddev php artisan make:model Museum -m
ddev php artisan make:migration create_museum_topic_table

# Factory y Seeders
ddev php artisan make:factory MuseumFactory --model=Museum
ddev php artisan migrate:fresh --seed

# Controladores
ddev php artisan make:controller MuseumController
ddev php artisan make:controller Api/ApiController

# API
ddev php artisan install:api --without-migration-prompt

# Storage
ddev php artisan storage:link

# Tinker
ddev php artisan tinker
```
