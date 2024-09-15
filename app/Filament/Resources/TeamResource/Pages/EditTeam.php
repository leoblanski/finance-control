<?php

namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use Filament\Resources\Pages\EditRecord;

class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;

    public function mount(int | string $record): void
    {
        $this->record = auth()->user()->team;

        static::authorizeResourceAccess();
        $this->fillForm();
    }

    // protected function beforeSave()
    // {
    //     if ($this->form->getState()['brand_logo'] != $this->record->brand_logo && $this->record->brand_logo) {
    //         $s3 = new S3();
    //         $s3->delete($this->record->brand_logo);
    //     }
    // }

    protected function afterSave()
    {
        redirect()->route('filament.user.resources.team.edit', ['record' => $this->record->id]);
    }
}
