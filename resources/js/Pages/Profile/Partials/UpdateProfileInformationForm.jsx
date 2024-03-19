import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, useForm, usePage } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import { useState, useEffect } from 'react';

export default function UpdateProfileInformation({ mustVerifyEmail, status, className = '' }) {
    const { auth } = usePage().props;
    const { user } = auth;

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        name: user.name,
        email: user.email,
        points: user.points,
        mood: user.mood,
    });

    const submit = (e) => {
        e.preventDefault();
        const newData = {
            ...data,
            points: data.mood !== user.mood ? data.points + 1 : data.points,
        };
        setData(newData);
        patch(route('profile.update'));
    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Profil de {data.name}</h2>
                <p className="mt-1 text-sm text-gray-600">
                    Update your account's profile information and email address.
                </p>
            </header>


            <div className="font-bold">
                <div className="font-bold">Points: {data.points ?? 0}</div>
                <div>
                    Badge: {data.points <= 1500 ? (
                    <Link href="/association" as="a">
                        <img src="/assets/badges/sword.svg" alt="Your Image"width="50" />
                    </Link>
                ) : (
                    <Link href="/association" as="a">
                        <img src="/assets/badges/crown.svg" alt="Your Image" width="50" />
                    </Link>
                )}
                </div>
            </div>

            <form onSubmit={submit} className="mt-6 space-y-6">
                <div>
                    <InputLabel value="Mood" />
                    <div className="mt-1">
                        <label className="inline-flex items-center">
                            <input
                                type="radio"
                                className="form-radio"
                                value="😀"
                                checked={data.mood === '😀'}
                                onChange={() => setData('mood', '😀')}
                            />
                            <span className="ml-2">😀</span>
                        </label>
                        <label className="inline-flex items-center ml-6">
                            <input
                                type="radio"
                                className="form-radio"
                                value="😄"
                                checked={data.mood === '😄'}
                                onChange={() => setData('mood', '😄')}
                            />
                            <span className="ml-2">😄</span>
                        </label>
                    </div>
                </div>

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>Save</PrimaryButton>
                    <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <p className="text-sm text-gray-600">Saved.</p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
