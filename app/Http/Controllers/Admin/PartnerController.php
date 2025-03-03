<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Http\Resources\Admin\PartnerResource;
use App\Models\Partner;
use App\Traits\HasFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class PartnerController extends Controller
{
    use HasFile;
    public function index(): Response
    {
        $partners = Partner::query()
            ->select(['id', 'name', 'description', 'logo', 'slug', 'address', 'contact', 'created_at'])
            ->filter(request()->only(['search']))
            ->sorting(request()->only(['field', 'direction']))
            ->paginate(request()->load ?? 10);

        return inertia('Admin/Partners/Index', [
            'page_settings' => [
                'title' => 'Mitra MBKM',
                'subtitle' => 'Menampilkan semua data mitra MBKM yang tersedia'
            ],

            'partners' => PartnerResource::collection($partners)->additional([
                'meta' => [
                    'has_pages' => $partners->hasPages(),
                ],
            ]),

            'state' => [
                'page' => request()->page ?? 1,
                'search' => request()->search ?? '',
                'load' => 10,
            ]
        ]);
    }

    public function create(): Response 
    {
        return inertia('Admin/Partners/Create', [
            'page_settings' => [
                'title' => 'Tambah Mitra MBKM',
                'subtitle' => 'Tambahkan Data Mitra MBKM baru. Klik simpan setelah selesai!',
                'method' => 'POST',
                'action' => route('admin.partners.store'),
            ]
        ]);
    }

    public function store(PartnerRequest $request): RedirectResponse 
    {
        try {
            Partner::create([
                'name' => $request->name,
                'description' => $request->description,
                'logo' => $this->upload_file($request, 'logo', 'partners'),
                'address' => $request->address,
                'contact' => $request->contact,
            ]);

            flashMessage(MessageType::CREATED->message('Mitra MBKM'));
            return to_route('admin.partners.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.partners.index');
        }
    }

    public function edit(Partner $partner): Response 
    {
        return inertia('Admin/Partners/Edit', [
            'page_settings' => [
                'title' => 'Edit Mitra MBKM',
                'subtitle' => 'Edit Data Mitra MBKM. Klik simpan setelah selesai!',
                'method' => 'PUT',
                'action' => route('admin.partners.update', $partner),
            ],
            'partner' => $partner,
        ]);
    }

    public function update(Partner $partner, PartnerRequest $request): RedirectResponse 
    {
        try {
            $partner->update([
                'name' => $request->name,
                'description' => $request->description,
                'logo' => $this->update_file($request, $partner, 'logo', 'partners'),
                'address' => $request->address,
                'contact' => $request->contact,
            ]);

            flashMessage(MessageType::UPDATED->message('Mitra MBKM'));
            return to_route('admin.partners.index');
        } catch (Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.partners.index');
        }
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        try {
            $this->delete_file($partner, 'logo');
            $partner->delete();
            flashMessage(MessageType::DELETED->message('Mitra MBKM'));
            return to_route('admin.partners.index');
        } catch(Throwable $e) {
            flashMessage(MessageType::ERROR->message(error: $e->getMessage()), 'error');
            return to_route('admin.partners.index');
        }
    }
}
