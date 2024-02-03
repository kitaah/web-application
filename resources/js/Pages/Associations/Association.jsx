import { usePage, Link } from '@inertiajs/react';

export default function Association() {
    const { association } = usePage().props;

    return (
        <div className="container mx-auto my-8 text-center">
            <h1 className="text-4xl font-bold mb-4 text-center">{association.name}</h1>

            <section className="mb-8 flex items-center justify-center">
                {association && (
                    <div>
                        <div className="flex justify-center items-center">
                            <img src={association.image} width="150" alt={association.name} />
                        </div>
                        <div>Catégorie: <strong>{association.category_name}</strong></div>< br />
                        <div>
                        <a href={association.url} className="px-6 py-2 mx-5 text-white bg-blue-500 rounded-md focus:outline-none" target="_blank" rel="noopener noreferrer">
                            Voir le site
                        </a></div>< br />
                        <div>Ville: <strong>{association.city}</strong></div>< br />
                        <div>Description: <strong>{association.description}</strong></div>< br />
                        <div>Projet: <strong>{association.project}</strong></div>
                    </div>
                )}
            </section>
        </div>
    );
}
