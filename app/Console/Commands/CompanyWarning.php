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

            if (
                $currentDate->month === $effectiveDate->month
                && $currentDate->day === $effectiveDate->day
                && ($currentDate->year + 2) === $effectiveDate->year
            ) {
                Log::info("Company {$company->company_id} will expire in 2 years");
                FilamentUtil::sendNotifToCompany(
                    url: route('filament.company.resources.company-legalizations.edit', $company->id),
                    title: 'Peringatan',
                    body: 'Peringatan! Waktu penerbitan regulasi perusahaan akan segera berakhir.',
                    companyId: $company->company_id,
                    sendEmail: true
                );
            }
        }

        Log::info("Done running company warning script");
    }
}
