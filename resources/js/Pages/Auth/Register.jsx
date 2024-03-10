import { useEffect } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import Select from 'react-select';
import ApplicationLogo from "@/Components/ApplicationLogo.jsx";
import Layout from '@/Layouts/Layout';

export default function Register() {
    const { props: { departments } } = usePage();
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        department: '',
        terms_accepted: false,
    });

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route('register'));
    };

    const departmentOptions = departments.map((department) => ({
        value: department,
        label: department,
    }));

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">S'inscrire</h2>}>
            <div className="container mx-auto my-8">
                <h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Inscription</h2>

                <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                    <div>
                        <Link href="/">
                            <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                        </Link>
                    </div>

                    <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form onSubmit={submit}>
                    <div>
                        <InputLabel htmlFor="name" value="Nom d'utilisateur" />
                        <TextInput
                            id="name"
                            name="name"
                            value={data.name}
                            className="mt-1 block w-full"
                            autoComplete="name"
                            isFocused={true}
                            onChange={(e) => setData('name', e.target.value)}
                            required
                        />
                        <InputError message={errors.name} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="department" value="Département" />
                        <Select
                            id="department"
                            name="department"
                            value={{ value: data.department, label: data.department }}
                            onChange={(selectedOption) => setData('department', selectedOption.value)}
                            options={departmentOptions}
                            isSearchable={true}
                            maxMenuHeight={200}
                            noOptionsMessage={() => "Aucun département trouvé"}
                        />
                        <InputError message={errors.department} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-full"
                            autoComplete="username"
                            onChange={(e) => setData('email', e.target.value)}
                            required
                        />
                        <InputError message={errors.email} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="password" value="Mot de passe" />
                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => setData('password', e.target.value)}
                            required
                        />
                        <span className="text-sm text-gray-500">Au moins 8 caractères, une lettre majuscule, minuscule, un nombre et un caractère spécial.</span>
                        <InputError message={errors.password} className="mt-2" />
                    </div>
                    <div className="mt-4">
                        <InputLabel htmlFor="password_confirmation" value="Confirmation du mot de passe" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            value={data.password_confirmation}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            required
                        />
                        <InputError message={errors.password_confirmation} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <label htmlFor="terms_accepted" className="flex items-center">
                            <input
                                type="checkbox"
                                id="terms_accepted"
                                name="terms_accepted"
                                checked={data.terms_accepted}
                                onChange={(e) => setData('terms_accepted', e.target.checked)}
                                className="form-checkbox"
                            />
                            <span className="ml-2">J'accepte <Link
                                href={route('termsandconditions')} className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">les conditions générales d'utilisation</Link>
                            </span>
                        </label>
                        <InputError message={errors.terms_accepted} className="mt-2" />
                    </div>

                    <div className="flex items-center justify-end mt-4">
                        <Link
                            href={route('login')}
                            className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Déjà inscrit ? Connectez-vous
                        </Link>
                        <PrimaryButton className="ms-4" disabled={processing}>
                            S'inscrire
                        </PrimaryButton>
                    </div>
                </form>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
