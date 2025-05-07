<?php

namespace App\Console\Commands;

use App\Models\Company\CompanyLegalization;
use App\Utils\FilamentUtil;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CompanyWarning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:company-warning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("Running company warning script...");

        $companies = CompanyLegalization::all();
        $currentDate = Carbon::now();

        foreach ($companies as $company) {
            $effectiveDate = $company->company_regulation_effective_date;
            if (!$effectiveDate) continue;
            $effectiveDate = Carbon::parse($effectiveDate);

            if ($effectiveDate->isSameDay($currentDate->addYear(2))) {
                FilamentUtil::sendNotifToCompany(
                    url: route('filament.company.resources.company-legalizations.edit', $company->id),
                    title: 'Peringatan',
                    body: 'Peringatan! Waktu penerbitan regulasi perusahaan akan segera berlalu.',
                    companyId: $company->company_id,
                    sendEmail: true
                );
            }
        }
    }
}
