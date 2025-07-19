\<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstrumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instrumentTypes = [
            ['id' => 1, 'name' => 'Deed of Transfer', 'description' => 'A legal document that transfers ownership of property from one party to another', 'is_active' => true],
            ['id' => 2, 'name' => 'Certificate of Occupancy', 'description' => 'An official government-issued certificate that legally proves the right to occupy and use a specific parcel of land', 'is_active' => true],
            ['id' => 3, 'name' => 'ST Certificate of Occupancy', 'description' => 'A specialized CofO issued for individual units within a multi-unit development under the Sectional Titling framework', 'is_active' => true],
            ['id' => 4, 'name' => 'SLTR Certificate of Occupancy', 'description' => 'A CofO issued under the SLTR scheme to formalize land rights in informal or previously undocumented settlements', 'is_active' => true],
            ['id' => 5, 'name' => 'Irrevocable Power of Attorney', 'description' => 'A non-revocable legal instrument that permanently empowers the attorney to act on behalf of the donor in managing or transferring land/property rights', 'is_active' => true],
            ['id' => 6, 'name' => 'Deed of Release', 'description' => 'A document that discharges or releases a party from a previous claim, interest, or mortgage on a property', 'is_active' => true],
            ['id' => 7, 'name' => 'Deed of Assignment', 'description' => 'A document that legally transfers ownership of an interest in land or property from one party (assignor) to another (assignee)', 'is_active' => true],
            ['id' => 8, 'name' => 'ST Assignment', 'description' => 'A specialized assignment document for sectional title properties', 'is_active' => true],
            ['id' => 9, 'name' => 'Deed of Mortgage', 'description' => 'A formal agreement used to secure a loan against landed property, with the lender holding interest until full repayment', 'is_active' => true],
            ['id' => 10, 'name' => 'Tripartite Mortgage', 'description' => 'A three-party agreement involving the borrower, lender, and property owner, typically used where the borrower is not the titleholder', 'is_active' => true],
            ['id' => 11, 'name' => 'Deed of Sub Lease', 'description' => 'An agreement where a lessee (not the owner) leases part or all of the leased property to another party', 'is_active' => true],
            ['id' => 12, 'name' => 'Deed of Sub Under Lease', 'description' => 'A document used when a sub-lessee further leases out the property to a third party, creating an additional layer of tenancy', 'is_active' => true],
            ['id' => 13, 'name' => 'Power of Attorney', 'description' => 'A legal document granting authority to a person (the attorney) to act on behalf of another (the donor) in property-related matters', 'is_active' => true],
            ['id' => 14, 'name' => 'Deed of Surrender', 'description' => 'A legal agreement in which a tenant or lessee voluntarily returns possession of property to the landlord or lessor before the lease expires', 'is_active' => true],
            ['id' => 15, 'name' => 'Indenture of Lease', 'description' => 'A formal lease agreement that creates a legal relationship between landlord and tenant for a specified period', 'is_active' => true],
            ['id' => 16, 'name' => 'Deed of Variation', 'description' => 'A document used to modify the terms or conditions of an existing land-related agreement without invalidating it', 'is_active' => true],
            ['id' => 17, 'name' => 'Customary Right of Occupancy', 'description' => 'A traditional land tenure system that grants occupancy rights based on customary law and practices', 'is_active' => true],
            ['id' => 18, 'name' => 'Vesting Assent', 'description' => 'A probate instrument used by executors or administrators to formally transfer property from a deceased estate to beneficiaries', 'is_active' => true],
            ['id' => 19, 'name' => 'Court Judgement', 'description' => 'A legal decision by a court that affects property rights or ownership', 'is_active' => true],
            ['id' => 20, 'name' => 'Exchange of Letters', 'description' => 'A formal correspondence that creates binding agreements regarding property matters', 'is_active' => true],
            ['id' => 21, 'name' => 'Tenancy Agreement', 'description' => 'A contractual agreement between landlord and tenant outlining terms of property rental', 'is_active' => true],
            ['id' => 22, 'name' => 'Revocation of Power of Attorney', 'description' => 'A legal document that cancels or revokes a previously granted power of attorney', 'is_active' => true],
            ['id' => 23, 'name' => 'Deed of Convenyence', 'description' => 'A legal document that transfers property ownership from one party to another', 'is_active' => true],
            ['id' => 24, 'name' => 'Memorandom of Agreement', 'description' => 'A formal document outlining the terms and conditions agreed upon by parties regarding property matters', 'is_active' => true],
            ['id' => 25, 'name' => 'Quarry Lease', 'description' => 'A specialized lease agreement for the extraction of minerals or materials from land', 'is_active' => true],
            ['id' => 26, 'name' => 'Private Lease', 'description' => 'A lease agreement between private parties for the use of property', 'is_active' => true],
            ['id' => 27, 'name' => 'Deed of Gift', 'description' => 'A legal document that transfers property ownership as a gift without monetary consideration', 'is_active' => true],
            ['id' => 28, 'name' => 'Deed of Partition', 'description' => 'A legal document that divides jointly owned property among co-owners', 'is_active' => true],
            ['id' => 29, 'name' => 'Non-European Occupational Lease', 'description' => 'A historical lease type for non-European occupants under colonial land laws', 'is_active' => true],
            ['id' => 30, 'name' => 'Deed of Revocation', 'description' => 'A legal document that cancels or revokes a previously executed deed or agreement', 'is_active' => true],
            ['id' => 31, 'name' => 'Deed of lease', 'description' => 'A contractual document that grants possession and use of land or property to a lessee for a specified period under agreed terms', 'is_active' => true],
            ['id' => 32, 'name' => 'Deed of Reconveyance', 'description' => 'A document that transfers property back to the original owner, typically after mortgage satisfaction', 'is_active' => true],
            ['id' => 33, 'name' => 'Letter of Administration', 'description' => 'A legal document granting authority to administer the estate of a deceased person', 'is_active' => true],
            ['id' => 34, 'name' => 'Customary Inhertitance', 'description' => 'Property transfer based on traditional inheritance laws and customs', 'is_active' => true],
            ['id' => 35, 'name' => 'Certificate of Purchase', 'description' => 'A document evidencing the purchase of property or land rights', 'is_active' => true],
            ['id' => 36, 'name' => 'Deed of Rectification', 'description' => 'A legal document that corrects errors or omissions in previously executed deeds', 'is_active' => true],
            ['id' => 37, 'name' => 'Building Lease', 'description' => 'A lease agreement specifically for building or construction purposes on land', 'is_active' => true],
            ['id' => 38, 'name' => 'Memorandum of Loss', 'description' => 'A document recording the loss of original property documents and requesting replacement', 'is_active' => true],
            ['id' => 39, 'name' => 'Vesting Deed', 'description' => 'A legal document that formally vests property ownership in a specified party', 'is_active' => true],
            ['id' => 40, 'name' => 'ST Fragmentation', 'description' => 'A process of dividing sectional title properties into smaller units or portions', 'is_active' => true],
        ];

        // Clear existing data
        DB::table('instrument_types')->truncate();

        // Insert new data
        foreach ($instrumentTypes as $type) {
            DB::table('instrument_types')->insert([
                'id' => $type['id'],
                'name' => $type['name'],
                'description' => $type['description'],
                'is_active' => $type['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}