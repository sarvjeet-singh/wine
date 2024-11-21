<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Exception;
use App\Models\VendorAccommodationMetadata;
use App\Models\VendorWineryMetadata;

class MigrationController extends Controller
{
    public function migrateVendorData()
    {
        // Start a transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Fetch all vendors
            $vendors = DB::table('vendors')->get();

            foreach ($vendors as $vendor) {
                if (!empty($vendor->country) && trim($vendor->country) == 'CA') {
                    DB::table('vendors')->where('id', $vendor->id)->update([
                        'country' => 2,
                    ]);
                }
                // $data = [];
                // if (!empty($vendor->tasting_options)) {
                //     $tastingOptionId = DB::table('tasting_options')
                //         ->where('name', trim($vendor->tasting_options)) // Assuming 'sub_category' is the name field
                //         ->value('id');
                //     if ($tastingOptionId) {
                //         // Update the vendor record with the new sub_category_id
                //         VendorWineryMetadata::updateOrCreate(
                //             ['vendor_id' => $vendor->id], // Match based on vendor ID
                //             [
                //                 'tasting_options' => $tastingOptionId,
                //             ]
                //         );
                //     }
                // }


                // if (!empty($vendor->checkin_start_time)) {
                //     $data['checkin_start_time'] = trim($vendor->checkin_start_time);
                // }
                // if (!empty($vendor->checkin_end_time)) {
                //     $data['checkin_end_time'] = trim($vendor->checkin_end_time);
                // }
                // if (!empty($vendor->checkout_time)) {
                //     $data['checkout_time'] = trim($vendor->checkout_time);
                // }
                // if (!empty($vendor->square_footage)) {
                //     $data['square_footage'] = trim($vendor->square_footage);
                // }
                // if (!empty($vendor->bedrooms)) {
                //     $data['bedrooms'] = trim($vendor->bedrooms);
                // }
                // if (!empty($vendor->washrooms)) {
                //     $data['washrooms'] = trim($vendor->washrooms);
                // }
                // if (!empty($vendor->sleeps)) {
                //     $data['sleeps'] = trim($vendor->sleeps);
                // }
                // if (!empty($vendor->current_rate)) {
                //     $data['current_rate'] = trim($vendor->current_rate);
                // }
                // if (!empty($vendor->extension)) {
                //     $data['extension'] = trim($vendor->extension);
                // }
                // if (!empty($vendor->process_type)) {
                //     $data['process_type'] = trim($vendor->process_type);
                // }
                // if (!empty($vendor->redirect_url)) {
                //     $data['redirect_url'] = trim($vendor->redirect_url);
                // }
                // if (!empty($vendor->booking_minimum)) {
                //     $data['booking_minimum'] = trim($vendor->booking_minimum);
                // }
                // if (!empty($vendor->booking_maximum)) {
                //     $data['booking_maximum'] = trim($vendor->booking_maximum);
                // }
                // if (!empty($vendor->security_deposit_amount)) {
                //     $data['security_deposit_amount'] = trim($vendor->security_deposit_amount);
                // }
                // if (!empty($vendor->applicable_taxes_amount)) {
                //     $data['applicable_taxes_amount'] = trim($vendor->applicable_taxes_amount);
                // }
                // if (!empty($vendor->cleaning_fee_amount)) {
                //     $data['cleaning_fee_amount'] = trim($vendor->cleaning_fee_amount);
                // }
                // if (!empty($vendor->beds)) {
                //     $data['beds'] = trim($vendor->beds);
                // }
                // if (!is_null($vendor->pet_boarding)) { // boolean can be false
                //     $data['pet_boarding'] = trim($vendor->pet_boarding);
                // }

                // // Only create or update the vendor_accommodation_metadata if there's data to insert
                // if (!empty($data)) {
                //     VendorAccommodationMetadata::updateOrCreate(
                //         ['vendor_id' => $vendor->id], // Match based on vendor ID
                //         $data
                //     );
                // }


                // Check if sub_category exists in the sub_categories table
                // $subCategoryId = DB::table('sub_categories')
                //     ->where('name', trim($vendor->vendor_sub_category)) // Assuming 'sub_category' is the name field
                //     ->value('id');

                // if ($subCategoryId) {
                //     // Update the vendor record with the new sub_category_id
                //     DB::table('vendors')->where('id', $vendor->id)->update([
                //         'vendor_sub_category' => $subCategoryId,
                //     ]);
                // }

                // // Check if country exists in the countries table
                // $countryId = DB::table('countries')
                //     ->where('name', trim($vendor->country)) // Assuming 'country' is the name field
                //     ->value('id');

                // if ($countryId) {
                //     // Update the vendor record with the new country_id
                //     DB::table('vendors')->where('id', $vendor->id)->update([
                //         'country' => $countryId,
                //     ]);
                // }

                // $subRegionId = DB::table('sub_regions')
                //     ->where('name', trim($vendor->sub_region)) // Assuming 'country' is the name field
                //     ->value('id');

                // if ($subRegionId) {
                //     // Update the vendor record with the new country_id
                //     DB::table('vendors')->where('id', $vendor->id)->update([
                //         'sub_region' => $subRegionId,
                //     ]);
                // }

                // $inventoryTypeId = DB::table('inventory_types')
                //     ->where('name', trim($vendor->inventory_type)) // Assuming 'country' is the name field
                //     ->value('id');

                // if ($inventoryTypeId) {
                //     // Update the vendor record with the new country_id
                //     DB::table('vendors')->where('id', $vendor->id)->update([
                //         'inventory_type' => $inventoryTypeId,
                //     ]);
                // }

                // Add similar logic for other related tables if needed
            }

            // Commit the transaction if all is well
            DB::commit();

            // Return success response
            return response()->json(['message' => 'Vendor data migration completed successfully.']);
        } catch (Exception $e) {
            // Rollback if something goes wrong
            DB::rollBack();

            // Return error response
            return response()->json(['message' => 'Vendor data migration failed: ' . $e->getMessage()], 500);
        }
    }
}
