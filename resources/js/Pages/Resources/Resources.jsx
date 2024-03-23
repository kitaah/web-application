import Layout from '@/Layouts/Layout';
import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Resources() {
    const { resources, categories } = usePage().props;
    const [selectedCategory, setSelectedCategory] = useState('');

    const handleCategoryChange = (e) => {
        setSelectedCategory(e.target.value);
    };

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Ressource</h2>}>
        <div className="container mx-auto my-8">
            <h1 className="text-4xl font-bold mb-4 text-center">Liste des ressources</h1>

            <section className="mb-8 text-center">
                <h2 className="text-2xl font-bold mb-2 text-center">Consultez la liste des ressources</h2>
                <select className="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" onChange={handleCategoryChange} value={selectedCategory}>
                    <option value="">Sélectionnez une catégorie</option>
                    {categories.map(({ id, name }) => (
                        <option key={id} value={name}>{name}</option>
                    ))}
                </select>
            </section>

            <ul className="container mx-auto my-8 text-center">
                {resources
                    .filter(resource => !selectedCategory || resource.category_name === selectedCategory)
                    .map(({ category_name, id, image, name, slug, user_name, created_at, updated_at }) => (
                        <li key={id}>
                            <div>Titre: <strong>{name}</strong></div><br />
                            <div className="flex justify-center items-center">
                                <img src={image} width="400" alt={name} />
                            </div>
                            <Link href={route('resources.show', { slug: slug })}>
                                <button className="m-5 px-6 py-2 mx-5 text-white bg-green-500 rounded-md focus:outline-none">
                                    Voir la ressource
                                </button>
                            </Link>
                            <div>Catégorie: <strong>{category_name}</strong></div><br />
                            <div>Posté par: <strong>{user_name}</strong></div><br />
                            <div>Posté le: <strong>{created_at}</strong></div><br />
                            <div>Mise à jour le: <strong>{updated_at}</strong></div><br />
                        </li>
                    ))}
            </ul>
        </div>
        </Layout>
    );
}
