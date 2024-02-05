import React from 'react';
import { usePage, useForm, Link } from '@inertiajs/react';
import Layout from '@/Layouts/Layout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import TextArea from '@/Components/TextArea';
import FileInput from "@/Components/FileInput";
import ApplicationLogo from "@/Components/ApplicationLogo.jsx";

const ImageEdit = () => {
    const { resource } = usePage().props;
    const { data, setData, post, processing, errors, reset } = useForm({
        image: null,
    });

    React.useEffect(() => {
        return () => {
            reset('image');
        };
    }, []);

    const handleImageChange = (e) => {
        setData('image', e.target.files[0]);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('image', data.image);

        post(route('image.update', resource.slug, formData));
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
                            <div className="mt-4">
                                <InputLabel htmlFor="image" value="Image" />
                                <FileInput
                                    type="file"
                                    id="image"
                                    name="image"
                                    onChange={handleImageChange}
                                    className="mt-1 block w-full"
                                    accept="image/*"
                                />
                                <InputError message={errors.image} className="mt-2" />
                            </div>

                            <div className="flex items-center justify-end mt-4">
                                <PrimaryButton type="submit" disabled={processing}>
                                    Modifier l'image
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Layout>
    );
};

export default ImageEdit;
