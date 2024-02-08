import Layout from '@/Layouts/Layout';
import {Link, usePage } from '@inertiajs/react';
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.jsx";
import ImageEdit from "@/Pages/Resources/ImageEdit.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import DangerButton from "@/Components/DangerButton.jsx";
import SecondaryButton from "@/Components/SecondaryButton.jsx";

export default function UserResources() {
    const { userResources } = usePage().props;

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Mes ressources</h2>}>
            <div className="container mx-auto my-8">
                <section className="mb-8">
                    <div className="container mx-auto my-8">
                        <h1 className="text-4xl font-bold mb-4 text-center">Mes ressources</h1>

                        <div className="text-3xl font-bold mb-4 text-center">Listing de vos ressources</div>

                        <div className="text-center">
                            <button className="m-5 px-6 py-2 mt-4 text-white bg-green-500 rounded-md focus:outline-none">
                                <Link href={route('resource.create')} active={route().current('resource.create')}>
                                    Ajouter une ressource
                                </Link>
                            </button>
                        </div>

                        <section className="mb-8">
                            <ul className="mb-2">
                                {userResources.map(({ category_name, id, name, status, slug, created_at, updated_at, is_validated }) => (
                                    <div key={id}>
                                        <div>
                                            <div className="relative overflow-x-auto">
                                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" className="px-6 py-3">
                                                            Nom
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Catégorie
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Création
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Modification
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Statut
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Voir
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Modifier la ressource
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            Modifier l'image
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                        <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {name}
                                                        </th>
                                                        <td className="px-6 py-4">
                                                            {category_name}
                                                        </td>
                                                        <th scope="col" className="px-6 py-3">
                                                            {created_at}
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            {updated_at}
                                                        </th>
                                                        <th scope="col" className="px-6 py-3">
                                                            {status}
                                                        </th>
                                                        <td className="px-6 py-4">
                                                            {status === "En attente" || status === "Suspendue" || !is_validated ? (
                                                                <DangerButton>Indisponible</DangerButton>
                                                            ) : (
                                                                <Link href={route('resources.show', { slug: slug })}>
                                                                    <SecondaryButton>
                                                                        Voir
                                                                    </SecondaryButton>
                                                                </Link>
                                                            )}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {status === "En attente" || status === "Suspendue" || !is_validated ? (
                                                                <DangerButton>Indisponible</DangerButton>
                                                            ) : (
                                                                <Link href={route('resource.edit', { slug: slug })}>
                                                                    <SecondaryButton>
                                                                        Modifier
                                                                    </SecondaryButton>
                                                                </Link>
                                                            )}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {(status === "En attente" || status === "Suspendue" || !is_validated) ? (
                                                                <DangerButton>Indisponible</DangerButton>
                                                            ) : (
                                                                <Link href={route('image.edit', { slug: slug })}>
                                                                    <SecondaryButton>
                                                                        Modifier
                                                                    </SecondaryButton>
                                                                </Link>
                                                            )}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </ul>
                        </section>
                    </div>
                </section>
            </div>
        </Layout>
    );
}
