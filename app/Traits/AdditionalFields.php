<?php

namespace App\Traits;

use App\AdditionalField;
use Illuminate\Support\Collection;

trait AdditionalFields
{
    public function getAdditionalFieldListAttribute() {
        return AdditionalField::where('entity', static::class)->get();
    }

    public function getAdditionalFieldsAttribute() {
        return AdditionalField::where('entity', static::class)
            ->with(['values' => function($query) {
                $query->where('entity_id', $this->id);
            }])
            ->get()
            ->reduce(function($carry, $item) {
                $carry->put($item->key, json_decode($item->values->first()->value ?? $item->default ?? null));
                return $carry;
            }, new Collection());
    }

    public function setAdditionalField(string $key, $value) {
        $field = AdditionalField::where('entity', static::class)
            ->where('key', $key)
            ->with(['values' => function($query) {
                $query->where('entity_id', $this->id);
            }])
            ->first();

        if (!$field) {
            throw new \Exception("AdditionalField {$key} not found.");
        }

        if ($field->type !== gettype($value)) {
            throw new \InvalidArgumentException("{$key}'s value must be of type {$field->type}");
        }

        if ($field->values->first()) {
            $field_value = $field->values->first();
            $field_value->value = json_encode($value);
        } else {
            $field_value = AdditionalFieldValue::create([
                'additional_field_id' => $field->id,
                'entity_id' => $this->id,
                'value' => json_encode($value)
            ]);
        }

        $field_value->save();
    }
}
