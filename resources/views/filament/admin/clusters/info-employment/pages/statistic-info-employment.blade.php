<x-filament-panels::page>
    {{ $this->filtersForm }}
    <x-filament-widgets::widgets :columns="$this->getColumns()" :data="[...property_exists($this, 'filters') ? ['filters' => $this->filters] : [], ...$this->getWidgetData()]" :widgets="$this->getVisibleWidgets()" />
</x-filament-panels::page>
