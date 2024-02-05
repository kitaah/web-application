import { useEffect } from 'react';
import { usePage, useForm, Link } from '@inertiajs/react';
import Layout from '@/Layouts/Layout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import TextArea from '@/Components/TextArea';
import ApplicationLogo from "@/Components/ApplicationLogo.jsx";

const Edit = () => {
    const { resource, categories } = usePage().props;
    const { data, setData, post, processing, errors, reset } = useForm({
        name: resource.name,
        url: resource.url,
        description: resource.description,
        category_id: resource.category_id,
    });

    useEffect(() => {
        return () => {
            reset('name', 'url', 'description', 'category_id');
        };
    }, []);

    const handleNameChange = (e) => {
        setData('name', e.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('name', data.name);
        formData.append('url', data.url);
        formData.append('description', data.description);
        formData.append('category_id', data.category_id);

        post(route('resource.update', resource.slug, formData));
    };

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Ressource</h2>}>
            <div className="container mx-auto my-8">
                <h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Modifier une ressource</h2>

                <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                    <div>
                        <Link href="/">
                            <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                        </Link>
                    </div>

                    <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                        <form onSubmit={handleSubmit} method="POST" encType="multipart/form-data">
                            <div>
                                <InputLabel htmlFor="name" value="Nom" />
                                <TextInput
                                    id="name"
                                    name="name"
                                    value={data.name}
                                    className="mt-1 block w-full"
                                    autoComplete="name"
                                    isFocused={true}
                                    onChange={handleNameChange}
                                />
                                <InputError message={errors.name} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="description" value="Description" />
                                <TextArea
                                    id="description"
                                    name="description"
                                    value={data.description}
                                    className="mt-1 block w-full"
                                    autoComplete="description"
                                    onChange={(e) => setData('description', e.target.value)}
                                />
                                <InputError message={errors.description} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="url" value="Url" />
                                <TextInput
                                    id="url"
                                    name="url"
                                    value={data.url}
                                    className="mt-1 block w-full"
                                    autoComplete="url"
                                    onChange={(e) => setData('url', e.target.value)}
                                />
                                <InputError message={errors.description} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="category_id" value="Catégorie" />
                                <select
                                    id="category_id"
                                    name="category_id"
                                    value={data.category_id}
                                    onChange={(e) => setData('category_id', e.target.value)}
                                    className="mt-1 block w-full"
                                >
                                    <option value="" disabled>Sélectionnez une catégorie</option>
                                    {categories.map(category => (
                                        <option key={category.id} value={category.id}>{category.name}</option>
                                    ))}
                                </select>
                                <InputError message={errors.category_id} className="mt-2" />
                            </div>

                            <div className="flex items-center justify-end mt-4">
                                <PrimaryButton type="submit" disabled={processing}>
                                    Modifier la ressource
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Layout>
    );
};

export default Edit;
