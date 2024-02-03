import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { usePage } from '@inertiajs/react';

export default function Resource() {
    const { resource } = usePage().props;

    return (
        <div className="container mx-auto my-8">
            <h1 className="text-4xl font-bold mb-4 text-center">{resource.name}</h1>

            <section className="mb-8">
                <img src={resource.image} width="400" alt={resource.name} />
                <div>Url : <strong>{resource.url}</strong></div><br />
                <div>Description : <strong>{resource.description}</strong></div><br />
                <div>Catégorie : <strong>{resource.category_name}</strong></div><br />
                <div>Posté par : <strong>{resource.user_name}</strong></div><br />
                <div>Posté le : <strong>{resource.created_at}</strong></div><br />
                <div>Mise à jour le : <strong>{resource.updated_at}</strong></div><br />
            </section>
        </div>
    );
};
