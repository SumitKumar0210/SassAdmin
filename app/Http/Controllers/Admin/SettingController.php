<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\AdminConfiguration;
use App\Services\AdminAuditService;

class SettingController extends Controller
{
    public function showConfiguration()
    {
        $config = AdminConfiguration::first();
        return view('admin.setting.general_setting', compact('config'));
    }

    public function updateConfiguration(Request $request)
    {
        try {
        $validated = $request->validate([
            'name'            => 'required|string|min:3|max:255',
            'email'           => 'nullable|email|max:255',
            'mobile'          => 'nullable|digits:10',
            'gst'             => [
                'nullable',
                'string',
                'size:15',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'
            ],
            'address'         => 'nullable|string|max:500',
            'city'            => 'nullable|string|max:100',
            'state'           => 'nullable|string|max:100',
            'pincode'         => 'nullable|digits:6',
            'country'         => 'nullable|string|max:100',

            'invoice_prefix'  => 'required|string|max:10',
            'suffix_length'   => 'required|integer|min:1|max:6',
            'invoice_no'      => 'required|integer|min:1',
            'hsn'             => 'nullable|string|max:20',

            'status'          => 'required|boolean',

            'logo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'gst.regex'       => 'Invalid GST format.',
            'mobile.digits'   => 'Mobile number must be 10 digits.',
            'pincode.digits'  => 'Pincode must be 6 digits.',
        ]);

        $configuration = AdminConfiguration::firstOrNew([]);

        // $configuration->site_name = $request->input('site_name');

        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('logos', 'public');
            $configuration->site_logo = $logoPath;
        }

        $configuration->name = $request->name;
        $configuration->email = $request->email;
        $configuration->gst = $request->gst;
        $configuration->address = $request->address;
        $configuration->city = $request->city;
        $configuration->mobile = $request->mobile;
        $configuration->state = $request->state;
        $configuration->pincode = $request->pincode;
        $configuration->country = $request->country;
        $configuration->invoice_prefix = $request->invoice_prefix;
        $configuration->suffix_length = $request->suffix_length;
        $configuration->invoice_no = $request->invoice_no;
        $configuration->hsn = $request->hsn;
        $configuration->status = $request->status;

        // Update other configuration fields as needed

      
        $configuration->save();
        AdminAuditService::log('application_configuration_updated', $configuration, ['request_data' => $request->all()]);

        return redirect()->back()->with('success', 'Configuration updated successfully.');
        } catch (\Exception $e) {
            
            return redirect()->back()->with('error', 'An error occurred while updating configuration: ' . $e->getMessage());
        }
    }
}
