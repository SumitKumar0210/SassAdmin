<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Plan;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;



class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    // public function store(Request $request)
    // {

    //     try {
    //         // Validate request
    //         $validated = $request->validate([
    //             'name' => [
    //                 'required',
    //                 'string',
    //                 'min:3',
    //                 'max:100',
    //                 'unique:plans,name'
    //             ],
    //             'price' => [
    //                 'required',
    //                 'numeric',
    //                 'min:0',
    //                 'max:999999.99'
    //             ],
    //             'billing_cycle' => [
    //                 'required',
    //                 'in:monthly,quarterly,half_yearly,yearly'
    //             ],
    //             'modules' => [
    //                 'required',
    //             ],

    //         ], [
    //             // Custom error messages
    //             'name.required' => 'Plan name is required',
    //             'name.unique' => 'This plan name already exists',
    //             'price.required' => 'Price is required',
    //             'price.numeric' => 'Price must be a valid number',
    //             'price.min' => 'Price cannot be negative',
    //             'billing_cycle.required' => 'Please select a billing cycle',
    //             'billing_cycle.in' => 'Invalid billing cycle selected',
    //             'modules.required' => 'Please select at least one module',
    //         ]);

    //         \DB::beginTransaction();

    //         // Decode and validate modules JSON
    //         $modules = json_encode($validated['modules'], true);


    //         if (json_last_error() !== JSON_ERROR_NONE) {
    //             throw new \Exception('Invalid modules format');
    //         }



    //         // Create plan
    //         $plan = Plan::create([
    //             'name' => $validated['name'],
    //             'price' => $validated['price'],
    //             'billing_cycle' => $validated['billing_cycle'],
    //             'modules' => $modules
    //         ]);

    //         DB::commit();

    //         Log::info('Plan created successfully', [
    //             'plan_id' => $plan->id,
    //             'name' => $plan->name,
    //             'created_by' => auth()->id()
    //         ]);

    //         return redirect()
    //             ->route('admin.plans.index')
    //             ->with('success', 'Plan created successfully!');
    //     } catch (ValidationException $e) {

    //         return redirect()
    //             ->back()
    //             ->withErrors($e->validator)
    //             ->withInput();
    //     } catch (\Exception $e) {
    //         DB::rollBack();


    //         Log::error('Failed to create plan', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //             'user_id' => auth()->id()
    //         ]);

    //         return redirect()
    //             ->back()
    //             ->with('error', 'Failed to create plan. Please try again.')
    //             ->withInput();
    //     }
    // }

    public function store(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'unique:plans,name'
                ],
                'price' => [
                    'required',
                    'numeric',
                    'min:0',
                    'max:999999.99'
                ],
                'billing_cycle' => [
                    'required',
                    'in:monthly,quarterly,half_yearly,yearly'
                ],
                'modules' => [
                    'required',
                    'json'
                ],
            ], [
                // Custom error messages
                'name.required' => 'Plan name is required',
                'name.unique' => 'This plan name already exists',
                'price.required' => 'Price is required',
                'price.numeric' => 'Price must be a valid number',
                'price.min' => 'Price cannot be negative',
                'billing_cycle.required' => 'Please select a billing cycle',
                'billing_cycle.in' => 'Invalid billing cycle selected',
                'modules.required' => 'Please select at least one module',
                'modules.json' => 'Invalid modules format',
            ]);

            DB::beginTransaction();

            // Decode and validate modules JSON
            $modules = json_decode($validated['modules'], true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($modules) || empty($modules)) {
                throw new \Exception('Invalid modules format');
            }

            // Create plan
            $plan = Plan::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'billing_cycle' => $validated['billing_cycle'],
                'modules' => json_encode($modules)
            ]);

            DB::commit();

            Log::info('Plan created successfully', [
                'plan_id' => $plan->id,
                'name' => $plan->name,
                'created_by' => auth()->id()
            ]);

            return redirect()
                ->route('admin.plans.index')
                ->with('success', 'Plan created successfully!');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to create plan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to create plan. Please try again.')
                ->withInput();
        }
    }

    public function edit(Request $request, $id)
    {

        $plan = Plan::find($id);
        if (!$plan) {
            return redirect()
                ->back()
                ->with('error', 'Plan not found ')
                ->withInput();
        }
        $plan->modules = json_decode($plan->modules, true);

        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        try {

            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'unique:plans,name,' . $id,
                ],
                'price' => [
                    'required',
                    'numeric',
                    'min:0',
                    'max:999999.99'
                ],
                'billing_cycle' => [
                    'required',
                    'in:monthly,quarterly,half_yearly,yearly'
                ],
                'modules' => [
                    'required',
                ],
            ], [
                'name.required' => 'Plan name is required',
                'name.unique' => 'This plan name already exists',
                'price.required' => 'Price is required',
                'price.numeric' => 'Price must be a valid number',
                'price.min' => 'Price cannot be negative',
                'billing_cycle.required' => 'Please select a billing cycle',
                'billing_cycle.in' => 'Invalid billing cycle selected',
                'modules.required' => 'Please select at least one module',
            ]);

            DB::beginTransaction();

            // ---------------- MODULES HANDLING ----------------
            // modules comes as JSON string from frontend
            $modules = json_decode($validated['modules'], true);

            if (!is_array($modules)) {
                throw new \Exception('Invalid modules format');
            }
            $plan = Plan::find($id);

            // ---------------- UPDATE PLAN ----------------
            $plan->update([
                'name'          => $validated['name'],
                'price'         => $validated['price'],
                'billing_cycle' => $validated['billing_cycle'],
                'modules'       => $modules, // stored as JSON
            ]);

            DB::commit();

            Log::info('Plan updated successfully', [
                'plan_id' => $id,
                'updated_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.plans.index')
                ->with('success', 'Plan updated successfully!');
        } catch (ValidationException $e) {

            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Failed to update plan', [
                'plan_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to update plan. Please try again.')
                ->withInput();
        }
    }

//     public function update(Request $request, $id)
// {
//     DB::beginTransaction();

//     try {

//         $validated = $request->validate([
//             'name' => [
//                 'required',
//                 'string',
//                 'min:3',
//                 'max:100',
//                 'unique:plans,name,' . $id,
//             ],
//             'price' => [
//                 'required',
//                 'numeric',
//                 'min:0',
//                 'max:999999.99'
//             ],
//             'billing_cycle' => [
//                 'required',
//                 'in:monthly,quarterly,half_yearly,yearly'
//             ],
//             'modules' => [
//                 'required',
//                 'array',
//                 'min:1'
//             ],
//         ], [
//             'name.required' => 'Plan name is required',
//             'name.unique' => 'This plan name already exists',
//             'price.required' => 'Price is required',
//             'price.numeric' => 'Price must be a valid number',
//             'price.min' => 'Price cannot be negative',
//             'billing_cycle.required' => 'Please select a billing cycle',
//             'billing_cycle.in' => 'Invalid billing cycle selected',
//             'modules.required' => 'Please select at least one module',
//             'modules.array' => 'Modules must be a valid array',
//         ]);

//         $plan = Plan::find($id);
//         $plan->update([
//             'name'          => $validated['name'],
//             'price'         => $validated['price'],
//             'billing_cycle' => $validated['billing_cycle'],
//             'modules'       => $validated['modules'], // already array
//         ]);

//         DB::commit();

//         Log::info('Plan updated successfully', [
//             'plan_id'    => $id,
//             'updated_by' => auth()->id(),
//         ]);

//         return redirect()
//             ->route('admin.plans.index')
//             ->with('success', 'Plan updated successfully!');

//     } catch (\Throwable $e) {

//         DB::rollBack();

//         Log::error('Failed to update plan', [
//             'plan_id' => $id,
//             'error'   => $e->getMessage(),
//             'user_id' => auth()->id(),
//         ]);

//         return redirect()
//             ->back()
//             ->with('error', 'Failed to update plan. Please try again.')
//             ->withInput();
//     }
// }


    public function destroy($id)
    {
        try {
            $plan = Plan::find($id);
            $plan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Plan deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete plan',
            ], 500);
        }
    }
}
