import Layout from '@/Layouts/Layout';
import { useState } from 'react';
import { usePage } from '@inertiajs/react';
import axios from 'axios';

export default function Profile() {
    const { user } = usePage().props;

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Utilisateur</h2>}>
            <div className="container mx-auto my-8 text-center">
                <h1 className="text-4xl font-bold mb-4 text-center">{user.name}</h1>
                <h1 className="text-4xl font-bold mb-4 text-center">{user.email}</h1>
                {user.roles && user.roles.length > 0 && (
                    <div className="mb-4">
                        <h2 className="text-xl font-semibold mb-2">Rôles :</h2>
                        <ul>
                            {user.roles.map((role, index) => (
                                <li key={index}>{role}</li>
                            ))}
                        </ul>
                    </div>
                )}
            </div>
        </Layout>
    );
}
