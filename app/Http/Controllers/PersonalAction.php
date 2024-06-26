<?php

namespace App\Http\Controllers;

use App\Models\Sicklist;
use App\Models\Vacation;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackerEvent;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TrackerEntry;
use Illuminate\Validation\Rule;

class PersonalAction extends Controller
{
    public function save(Request $request)
    {
        $user_id = $request->get('id');
        $fields = $request->get('fields');

        $validation_rules = [];
        $validation_messages = [];

        $user = null;
        if($user_id == null)
        {
            $user = new User();

            //to use prebuilt '|confirmed' rule
            $request->merge(['password_confirmation' => $fields['password_confirmation']]);

            $validation_rules['fields.password'] = 'required|string|min:8|confirmed';
            $validation_messages['fields.password.required'] = 'The password is required.';
            $validation_messages['fields.password.string'] = 'The password must be a valid string.';
            $validation_messages['fields.password.min'] = 'The password must be at least 8 characters';
            $validation_messages['fields.password.confirmed'] = 'The passwords do not match.';

            unset($fields['password_confirmation']);
            $fields['password'] = bcrypt($fields['password']);
        }
        else
        {
            $user = User::find($user_id);
        }

        $validation_rules['fields.name'] = ['required', Rule::unique('users', 'name')->ignore($user_id)];
        $validation_rules['fields.email'] = ['required', Rule::unique('users', 'email')->ignore($user_id)];
        $validation_messages['fields.name.unique'] = 'This name is already taken';
        $validation_messages['fields.email.unique'] = 'This email is already taken';

        $request->validate($validation_rules, $validation_messages);

        foreach ($fields as $field => $value)
        {
            $user->$field = $value;
        }

        $user->save();

        return redirect()->route('details-personal', $user->id);
    }

    public function delete(Request $request, int $user_id)
    {
        $user = User::find($user_id);
        if($user != null)
        {
            TrackerEntry::where('employee_id', $user_id)->delete();
            Vacation::where('employee_id', $user_id)->delete();
            Sicklist::where('employee_id', $user_id)->delete();

            $user->delete();
        }
        return ['success' => true];
    }

    public function changePassword(Request $request, int $user_id)
    {
        $result = ['success' => true];
        $user = User::find($user_id);

        if($user != null)
        {
            $password = $request->get('password');
            $password_confirmation = $request->get('password_confirmation');

            if($password == $password_confirmation)
            {
                if(strlen($password) >= 8)
                {
                    $password = bcrypt($password);
                    $user->password = $password;
                    $user->save();
                }
                else
                {
                    $result['success'] = false;
                    $result['error'] = 'Password is too short';
                }
            }
            else
            {
                $result['success'] = false;
                $result['error'] = 'Passwords do not match';
            }
        }

        return $result;
    }

}
