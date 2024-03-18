import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Categories() {
    const { categories } = usePage().props;
    const [selectedCategory, setSelectedCategory] = useState('');

    const handleCategoryChange = (e) => {
        setSelectedCategory(e.target.value);
    };

    return (
        <div className="container mx-auto my-8">
                <select className="block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200" onChange={handleCategoryChange} value={selectedCategory}>
                    <option value="">Sélectionnez une catégorie</option>
                    {categories.map(({ id, name }) => (
                        <option key={id} value={name}>{name}</option>
                    ))}
                </select>
                {selectedCategory && (
                    <Link href={`/category/${selectedCategory}`} className="block mt-4 text-center text-indigo-600 hover:underline">Voir les détails</Link>
                )}
        </div>
    );
}
